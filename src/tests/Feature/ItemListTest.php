<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Item;
use App\Models\User;
use App\Models\Sold;


class ItemListTest extends TestCase
{
    use RefreshDatabase;
    public function test_all_items_are_displayed_on_item_page()
    {
        $items = Item::factory()->count(3)->create();
        
        $response = $this->get('/');

        $response->assertStatus(200);

        foreach ($items as $item) {
            $response->assertSee($item->name);
        }
    }

    public function test_purchased_items_has_sold_label()
    {
        $user = User::factory()->create();
        $item = Item::factory()->create();

        Sold::factory()->create([
            'user_id' => $user->id,
            'item_id' => $item->id,
        ]);

        $response = $this->get('/');

        $response->assertStatus(200);

        $response->assertSee('SOLD');
    }

    public function test_user_does_not_see_own_items_in_list()
    {
        $user = User::factory()->create();

        $ownItem = Item::factory()->create([
            'user_id' => $user->id,
            'item_name' => '自分の商品',
        ]);

        $otherItem = Item::factory()->create([
            'item_name' => '他人の商品',
        ]);

        $response = $this->actingAs($user)->get('/mylist?tab=recommend');

        $response->assertStatus(200);

        $response->assertDontSee($ownItem->item_name);

        $response->assertSee($otherItem->item_name);

    }
}
