<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Item;
use App\Models\Condition;
use App\Models\ItemLike;
use App\Models\Purchase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class MyListTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        Condition::factory()->create(['name' => '新品']);
    }

    /** @test */
    public function liked_items_are_displayed()
    {
        $user = User::factory()->create();
        $item = Item::factory()->create([
            'name' => 'Liked Item',
            'condition_id' => 1,
            'price' => 1000,
        ]);

        ItemLike::factory()->create([
            'user_id' => $user->id,
            'item_id' => $item->id,
        ]);

        $this->actingAs($user);

        $response = $this->get('/?tab=mylist');

        $response->assertStatus(200);
        $response->assertSee('Liked Item');
    }

    /** @test */
    public function purchased_items_show_sold_label()
    {
        $user = User::factory()->create();
        $seller = User::factory()->create();

        $item = Item::factory()->create([
            'name' => 'Purchased Liked Item',
            'user_id' => $seller->id,
            'condition_id' => 1,
            'price' => 2000,
        ]);

        ItemLike::factory()->create([
            'user_id' => $user->id,
            'item_id' => $item->id,
        ]);

        Purchase::factory()->create([
            'user_id' => $user->id,
            'item_id' => $item->id,
        ]);

        $this->actingAs($user);

        $response = $this->get('/?tab=mylist');

        $response->assertStatus(200);
        $response->assertSee('Sold');
    }

    /** @test */
    public function guest_sees_nothing()
    {
        $response = $this->get('/?tab=mylist');

        $response->assertStatus(200);
        $response->assertDontSee('Item');
    }
}
