<?php


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
use Tests\TestCase;

class BVPointExpireCalculationTest extends TestCase
{
    use RefreshDatabase;

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

        // Create a package
        $parentPackage = PurchasedPackage::create([
            'user_id' => $parent->id,
            'purchaser_id' => $parent->id,
            'package_id' => 1,
            'invested_amount' => 100,
            'payable_percentage' => 1,
            'status' => 'ACTIVE',
        ]);

        // Create the purchased user
        $purchasedUser = User::factory()->create([
            'id' => 3,
            'super_parent_id' => $parent->id,
            'parent_id' => $parent->id,
            'position' => BinaryPlaceEnum::LEFT->value,
        ]);

        // Create a package
        $package = PurchasedPackage::create([
            'user_id' => $purchasedUser->id,
            'purchaser_id' => $purchasedUser->id,
            'package_id' => 8,
            'invested_amount' => 25000,
            'payable_percentage' => 1,
            'status' => 'ACTIVE',
        ]);

        // Dispatch the job
        CalculateBvPointsJob::dispatch($purchasedUser, $package)->onConnection('sync');

        // Assertions
        $parent->refresh();
        $this->assertEquals(4000, $parent->left_points_balance);
        $this->assertEquals(0, $parent->right_points_balance);


        // Create the purchased user
        $rightPurchasedUser = User::factory()->create([
            'id' => 4,
            'super_parent_id' => $parent->id,
            'parent_id' => $parent->id,
            'position' => BinaryPlaceEnum::RIGHT->value,
        ]);

        // Create a package
        $rightPurchasedUserPkg = PurchasedPackage::create([
            'user_id' => $rightPurchasedUser->id,
            'purchaser_id' => $rightPurchasedUser->id,
            'package_id' => 8,
            'invested_amount' => 25000,
            'payable_percentage' => 1,
            'status' => 'ACTIVE',
        ]);

        // Dispatch the job
        CalculateBvPointsJob::dispatch($rightPurchasedUser, $rightPurchasedUserPkg)->onConnection('sync');

        // Assertions
        $parent->refresh();
        $this->assertEquals(0, $parent->left_points_balance);
        $this->assertEquals(0, $parent->right_points_balance);

        // Check BVPointEarning record
        $this->assertDatabaseHas('bv_point_earnings', [
            'user_id' => $parent->id,
            'purchased_package_id' => $package->id,
            'purchaser_id' => $purchasedUser->id,
            'left_point' => 4000,
            'right_point' => 0,
        ]);
        $this->assertDatabaseHas('bv_point_earnings', [
            'user_id' => $parent->id,
            'purchased_package_id' => $rightPurchasedUserPkg->id,
            'purchaser_id' => $rightPurchasedUser->id,
            'left_point' => 0,
            'right_point' => 4000,
        ]);


        $this->assertDatabaseHas('purchased_package', [
            'status' => "EXPIRED",
        ]);

        $this->assertDatabaseHas('wallets', [
            'user_id' => $parent->id,
            'balance' => 400,
        ]);

    }

    public function test_already_earned_package()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('packages')->truncate();
        (new PackageSeeder())->run();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
        // Create the super parent
        $superParent = User::find(1);

        // Create the parent
        $parent = User::find(2);

        // Create a package
        $parentPackage = PurchasedPackage::create([
            'user_id' => $parent->id,
            'purchaser_id' => $parent->id,
            'package_id' => 1,
            'invested_amount' => 100,
            'package_earned_profit' => 100,
            'earned_profit' => 100,
            'payable_percentage' => 1,
            'status' => 'ACTIVE',
        ]);

        // Create the purchased user
        $purchasedUser = User::find(3);

        // Create a package
        $package = PurchasedPackage::create([
            'user_id' => $purchasedUser->id,
            'purchaser_id' => $purchasedUser->id,
            'package_id' => 8,
            'invested_amount' => 25000,
            'payable_percentage' => 1,
            'status' => 'ACTIVE',
        ]);

        // Dispatch the job
        CalculateBvPointsJob::dispatch($purchasedUser, $package)->onConnection('sync');

        // Assertions
        $parent->refresh();
        $this->assertEquals(4000, $parent->left_points_balance);
        $this->assertEquals(0, $parent->right_points_balance);


        // Create the purchased user
        $rightPurchasedUser = User::find(4);

        // Create a package
        $rightPurchasedUserPkg = PurchasedPackage::create([
            'user_id' => $rightPurchasedUser->id,
            'purchaser_id' => $rightPurchasedUser->id,
            'package_id' => 8,
            'invested_amount' => 25000,
            'payable_percentage' => 1,
            'status' => 'ACTIVE',
        ]);

        // Dispatch the job
        CalculateBvPointsJob::dispatch($rightPurchasedUser, $rightPurchasedUserPkg)->onConnection('sync');

        // Assertions
        $parent->refresh();
        $this->assertEquals(0, $parent->left_points_balance);
        $this->assertEquals(0, $parent->right_points_balance);

        // Check BVPointEarning record
        $this->assertDatabaseHas('bv_point_earnings', [
            'user_id' => $parent->id,
            'purchased_package_id' => $package->id,
            'purchaser_id' => $purchasedUser->id,
            'left_point' => 4000,
            'right_point' => 0,
        ]);
        $this->assertDatabaseHas('bv_point_earnings', [
            'user_id' => $parent->id,
            'purchased_package_id' => $rightPurchasedUserPkg->id,
            'purchaser_id' => $rightPurchasedUser->id,
            'left_point' => 0,
            'right_point' => 4000,
        ]);


        $this->assertDatabaseHas('purchased_package', [
            'user_id' => $parent->id,
            'package_earned_profit' => 100,
            'earned_profit' => 400,
            'status' => "EXPIRED",
        ]);

        $this->assertDatabaseHas('wallets', [
            'user_id' => $parent->id,
            'balance' => 700,
        ]);


    }
}
