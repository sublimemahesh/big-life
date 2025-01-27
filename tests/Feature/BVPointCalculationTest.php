<?php

namespace Tests\Feature;

use App\Enums\BinaryPlaceEnum;
use App\Jobs\CalculateBvPointsJob;
use App\Models\BvPointEarning;
use App\Models\BvPointReward;
use App\Models\PurchasedPackage;
use App\Models\User;
use App\Models\Wallet;
use Database\Seeders\PackageSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\DB;
use Log;
use Tests\TestCase;

class BVPointCalculationTest extends TestCase
{
    // use RefreshDatabase;

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_happy_path()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('packages')->truncate();
        (new PackageSeeder())->run();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
        // Create the super parent
        $superParent = User::factory()->create(['id' => 1]);

        // Create the parent
        $parent = User::factory()->create([
            'id' => 2,
            'parent_id' => $superParent->id,
            'position' => BinaryPlaceEnum::LEFT->value,
        ]);

        // Create the purchased user
        $purchasedUser = User::factory()->create([
            'id' => 3,
            'parent_id' => $parent->id,
            'position' => BinaryPlaceEnum::LEFT->value,
        ]);

        // Create a package
        $package = PurchasedPackage::create([
            'user_id' => $purchasedUser->id,
            'purchaser_id' => $purchasedUser->id,
            'package_id' => 1,
            'invested_amount' => 100,
            'payable_percentage' => 1,
            'status' => 'ACTIVE',
        ]);

        $this->assertEquals($purchasedUser->id, $package->user_id);

        $this->assertDatabaseHas('purchased_package', [
            'id' => 1,
        ]);

        // Dispatch the job
        CalculateBvPointsJob::dispatch($purchasedUser, $package)->onConnection('sync');

        // Assertions
        $parent->refresh();
        $this->assertEquals(20, $parent->left_points_balance);
        $this->assertEquals(0, $parent->right_points_balance);

        // Check BVPointEarning record
        $this->assertDatabaseHas('bv_point_earnings', [
            'user_id' => $parent->id,
            'purchased_package_id' => $package->id,
            'purchaser_id' => $purchasedUser->id,
            'left_point' => 20,
            'right_point' => 0,
        ]);

        // No reward should be issued
        $this->assertDatabaseMissing('bv_point_rewards', [
            'user_id' => $parent->id,
        ]);
    }

    public function test_balanced_bv_points()
    {
        // Create the super parent
        $superParent = User::find(1);

        // Create the parent
        $left_parent = User::find(2);

        // Create the left child
        $leftChild = User::find(3);

        // Create the right child (purchased user)
        $purchasedUser = User::factory()->create([
            'id' => 4,
            'parent_id' => $left_parent->id,
            'position' => BinaryPlaceEnum::RIGHT->value,
        ]);

        // Create a package
        $package = PurchasedPackage::create([
            'user_id' => $purchasedUser->id,
            'purchaser_id' => $purchasedUser->id,
            'package_id' => 1,
            'invested_amount' => 100,
            'payable_percentage' => 1,
            'status' => 'ACTIVE',
        ]);

        // Dispatch the job
        CalculateBvPointsJob::dispatch($purchasedUser, $package);

        // Assertions
        $superParent->refresh();
        $left_parent->refresh();

        $this->assertEquals(40, $superParent->left_points_balance);
        $this->assertEquals(0, $superParent->right_points_balance);

        $this->assertEquals(0, $left_parent->left_points_balance);
        $this->assertEquals(0, $left_parent->right_points_balance);

        // Check BVPointEarning record
        $this->assertDatabaseHas('bv_point_earnings', [
            'user_id' => $superParent->id,
            'purchased_package_id' => $package->id,
            'purchaser_id' => $purchasedUser->id,
            'left_point' => 20,
            'right_point' => 0,
        ]);

        $this->assertDatabaseHas('bv_point_earnings', [
            'user_id' => $left_parent->id,
            'purchased_package_id' => $package->id,
            'purchaser_id' => $purchasedUser->id,
            'left_point' => 0,
            'right_point' => 20,
        ]);

        $left_children_count = $left_parent->directSales()->where('position', BinaryPlaceEnum::LEFT->value)->count();
        $right_children_count = $left_parent->directSales()->where('position', BinaryPlaceEnum::RIGHT->value)->count();
        $eligibility = $left_children_count > 0 && $right_children_count > 0 ? 'claimed' : 'pending';

        // Check reward record
        $this->assertDatabaseHas('bv_point_rewards', [
            'user_id' => $left_parent->id,
            'bv_points' => 20,
            'amount' => 7, // USD value for 20 BV points
            'status' => $eligibility,
        ]);

        if ($eligibility === 'claimed') {
            $this->assertDatabaseHas('wallets', [
                'user_id' => $left_parent->id,
                'balance' => 7,
            ]);
        }
    }

    public function test_deep_tree()
    {

        // Create the super parent
        $superParent = User::find(1);

        // Create the parent
        $left_parent = User::find(2);

        // Create the left child
        $leftChild = User::find(3);

        // Create the right child
        $rightChild = User::find(4);

        // Create the left grandchild
        $leftGrandchild = User::factory()->create([
            'id' => 5,
            'parent_id' => $leftChild->id,
            'position' => BinaryPlaceEnum::LEFT->value,
        ]);

        // Create the left great grandchild
        $leftGreatGrandchild = User::factory()->create([
            'id' => 6,
            'parent_id' => $leftGrandchild->id,
            'position' => BinaryPlaceEnum::LEFT->value,
        ]);

        // Create the right grandchild (purchased user)
        $purchasedUser = User::factory()->create([
            'id' => 8,
            'parent_id' => $leftChild->id,
            'position' => BinaryPlaceEnum::RIGHT->value,
        ]);

        // Create a package
        $package = PurchasedPackage::create([
            'user_id' => $purchasedUser->id,
            'purchaser_id' => $purchasedUser->id,
            'package_id' => 1,
            'invested_amount' => 100,
            'payable_percentage' => 1,
            'status' => 'ACTIVE',
        ]);

        // Dispatch the job
        CalculateBvPointsJob::dispatch($purchasedUser, $package)->onConnection('sync');

        // Assertions for parent
        $leftChild->refresh();
        $left_parent->refresh();
        $superParent->refresh();

        $this->assertEquals(60, $superParent->left_points_balance);
        $this->assertEquals(0, $superParent->right_points_balance);

        $this->assertEquals(20, $left_parent->left_points_balance);
        $this->assertEquals(0, $left_parent->right_points_balance);

        $this->assertEquals(0, $leftChild->left_points_balance);
        $this->assertEquals(20, $leftChild->right_points_balance);

        // Check BVPointEarning record for parent
        $this->assertDatabaseHas('bv_point_earnings', [
            'user_id' => $leftChild->id,
            'purchased_package_id' => $package->id,
            'purchaser_id' => $purchasedUser->id,
            'left_point' => 0,
            'right_point' => 20,
        ]);


        // Check BVPointEarning record for grandparent
        $this->assertDatabaseHas('bv_point_earnings', [
            'user_id' => $left_parent->id,
            'purchased_package_id' => $package->id,
            'purchaser_id' => $purchasedUser->id,
            'left_point' => 20,
            'right_point' => 0,
        ]);

        // Check BVPointEarning record for great-grandparent super parent
        $this->assertDatabaseHas('bv_point_earnings', [
            'user_id' => $superParent->id,
            'purchased_package_id' => $package->id,
            'purchaser_id' => $purchasedUser->id,
            'left_point' => 20,
            'right_point' => 0,
        ]);

        $left_children_count = $left_parent->directSales()->where('position', BinaryPlaceEnum::LEFT->value)->count();
        $right_children_count = $left_parent->directSales()->where('position', BinaryPlaceEnum::RIGHT->value)->count();
        $left_parent_eligibility = $left_children_count > 0 && $right_children_count > 0 ? 'claimed' : 'pending';

        // Check reward record for parent
        $this->assertDatabaseHas('bv_point_rewards', [
            'user_id' => $left_parent->id,
            'bv_points' => 20,
            'amount' => 7, // USD value for 20 BV points
            'status' => $left_parent_eligibility,
        ]);

        // No reward should be issued for grandparent
        $this->assertDatabaseMissing('bv_point_rewards', [
            'user_id' => $superParent->id,
        ]);

        $this->assertDatabaseMissing('bv_point_rewards', [
            'user_id' => $leftChild->id,
        ]);
    }

    public function test_right_side_of_superparent(): void
    {
        // Create the super parent
        $superParent = User::find(1);

        // Create the parent
        $parent = User::factory()->create([
            'id' => 7,
            'parent_id' => $superParent->id,
            'position' => BinaryPlaceEnum::RIGHT->value,
        ]);

        // Create the purchased user
        $purchasedUser = User::factory()->create([
            'id' => 9,
            'parent_id' => $parent->id,
            'position' => BinaryPlaceEnum::RIGHT->value,
        ]);

        // Create a package
        $package = PurchasedPackage::create([
            'user_id' => $purchasedUser->id,
            'purchaser_id' => $purchasedUser->id,
            'package_id' => 1,
            'invested_amount' => 100,
            'payable_percentage' => 1,
            'status' => 'ACTIVE',
        ]);

        // Dispatch the job
        CalculateBvPointsJob::dispatch($purchasedUser, $package)->onConnection('sync');

        // Assertions
        $parent->refresh();
        $superParent->refresh();

        $this->assertEquals(40, $superParent->left_points_balance);
        $this->assertEquals(0, $superParent->right_points_balance);

        $this->assertEquals(0, $parent->left_points_balance);
        $this->assertEquals(20, $parent->right_points_balance);

        // Check BVPointEarning record
        $this->assertDatabaseHas('bv_point_earnings', [
            'user_id' => $superParent->id,
            'purchased_package_id' => $package->id,
            'purchaser_id' => $purchasedUser->id,
            'left_point' => 0,
            'right_point' => 20,
        ]);

        // Check BVPointEarning record
        $this->assertDatabaseHas('bv_point_earnings', [
            'user_id' => $parent->id,
            'purchased_package_id' => $package->id,
            'purchaser_id' => $purchasedUser->id,
            'left_point' => 0,
            'right_point' => 20,
        ]);

        $left_children_count = $superParent->directSales()->where('position', BinaryPlaceEnum::LEFT->value)->count();
        $right_children_count = $superParent->directSales()->where('position', BinaryPlaceEnum::RIGHT->value)->count();
        $superParent_eligibility = $left_children_count > 0 && $right_children_count > 0 ? 'claimed' : 'pending';

        // Check reward record for parent
        $this->assertDatabaseHas('bv_point_rewards', [
            'user_id' => $superParent->id,
            'bv_points' => 20,
            'amount' => 7, // USD value for 20 BV points
            'status' => $superParent_eligibility,
        ]);

        // No reward should be issued
        $this->assertDatabaseMissing('bv_point_rewards', [
            'user_id' => $parent->id,
        ]);

        if ($superParent_eligibility === 'claimed') {
            $this->assertEquals(7, $superParent->wallet->balance);
        }
        $this->assertEquals(0, $parent->wallet->balance);
    }
}
