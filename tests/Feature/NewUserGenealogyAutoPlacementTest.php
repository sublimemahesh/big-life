<?php

namespace Tests\Feature;

use App\Enums\BinaryPlaceEnum;
use App\Jobs\NewUserGenealogyAutoPlacement;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class NewUserGenealogyAutoPlacementTest extends TestCase
{
    // use RefreshDatabase;

    /**
     * A basic feature test example.
     *
     * @return void
     */
    /** @test */
    public function it_places_user_in_left_side_under_one_user()
    {
        $superParent = User::factory()->create(['id' => 1]);
        $purchasedUser = User::factory()->create(['id' => 2, 'super_parent_id' => 1, 'position' => BinaryPlaceEnum::LEFT->value]);

        NewUserGenealogyAutoPlacement::dispatch($purchasedUser)->onConnection('sync');
        $purchasedUser->refresh();
        $this->assertEquals(1, $purchasedUser->parent_id);
        $this->assertEquals(BinaryPlaceEnum::LEFT->value, $purchasedUser->position);
    }

    /** @test */
    public function it_places_user_left_under_parent_with_one_child()
    {
        $superParent = User::find(1);
        $parent = User::find(2);
        $purchasedUser = User::factory()->create(['id' => 3, 'super_parent_id' => $superParent->id, 'parent_id' => null, 'position' => BinaryPlaceEnum::LEFT->value]);

        NewUserGenealogyAutoPlacement::dispatch($purchasedUser)->onConnection('sync');
        $purchasedUser->refresh();
        $this->assertEquals($parent->id, $purchasedUser->parent_id);
        $this->assertEquals(BinaryPlaceEnum::LEFT->value, $purchasedUser->position);
    }

    /** @test */
     public function it_places_user_right_under_parent_with_one_child()
    {
        $superParent = User::find(2);
        $parent = User::find(2);
        $purchasedUser = User::factory()->create(['id' => 4, 'super_parent_id' => $superParent->id , 'parent_id' => null, 'position' => BinaryPlaceEnum::RIGHT->value]);

        NewUserGenealogyAutoPlacement::dispatch($purchasedUser)->onConnection('sync');
        $purchasedUser->refresh();
        $this->assertEquals($parent->id, $purchasedUser->parent_id);
        $this->assertEquals(BinaryPlaceEnum::RIGHT->value, $purchasedUser->position);
    }

    /** @test */
     public function it_places_user_right_under_parent_user3()
    {
        $superParent = User::find(3);
        $parent = User::find(3);
        $purchasedUser = User::factory()->create(['id' => 5, 'super_parent_id' => $superParent->id , 'parent_id' => null, 'position' => BinaryPlaceEnum::LEFT->value]);

        NewUserGenealogyAutoPlacement::dispatch($purchasedUser)->onConnection('sync');
        $purchasedUser->refresh();
        $this->assertEquals($parent->id, $purchasedUser->parent_id);
        $this->assertEquals(BinaryPlaceEnum::LEFT->value, $purchasedUser->position);
    }

    /** @test */
     public function it_places_user_left_under_parent_user5()
    {
        $superParent = User::find(1);
        $parent = User::find(5);
        $purchasedUser = User::factory()->create(['id' => 6, 'super_parent_id' => $superParent->id , 'parent_id' => null, 'position' => BinaryPlaceEnum::LEFT->value]);

        NewUserGenealogyAutoPlacement::dispatch($purchasedUser)->onConnection('sync');
        $purchasedUser->refresh();
        $this->assertEquals($parent->id, $purchasedUser->parent_id);
        $this->assertEquals(BinaryPlaceEnum::LEFT->value, $purchasedUser->position);
    }

    /** @test */
     public function it_places_user_right_under_parent_user1()
    {
        $superParent = User::find(1);
        $parent = User::find(1);
        $purchasedUser = User::factory()->create(['id' => 7, 'super_parent_id' => $superParent->id , 'parent_id' => null, 'position' => BinaryPlaceEnum::RIGHT->value]);

        NewUserGenealogyAutoPlacement::dispatch($purchasedUser)->onConnection('sync');
        $purchasedUser->refresh();
        $this->assertEquals($parent->id, $purchasedUser->parent_id);
        $this->assertEquals(BinaryPlaceEnum::RIGHT->value, $purchasedUser->position);
    }

    /** @test */
     public function it_places_user_right_under_parent_user7()
    {
        $superParent = User::find(1);
        $parent = User::find(7);
        $purchasedUser = User::factory()->create(['id' => 8, 'super_parent_id' => $superParent->id , 'parent_id' => null, 'position' => BinaryPlaceEnum::RIGHT->value]);

        NewUserGenealogyAutoPlacement::dispatch($purchasedUser)->onConnection('sync');
        $purchasedUser->refresh();
        $this->assertEquals($parent->id, $purchasedUser->parent_id);
        $this->assertEquals(BinaryPlaceEnum::RIGHT->value, $purchasedUser->position);
    }
}
