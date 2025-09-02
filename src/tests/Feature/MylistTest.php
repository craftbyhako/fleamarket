<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use App\Models\Item;
use App\Models\Like;
use App\Models\Sold;



class MylistTest extends TestCase
{
    use RefreshDatabase;

    public function test_liked_items_are_displayed_in_mylist()
    {
        $user = User::factory()->create();
        $likedItem = Item::factory()->create([
            'item_name' => 'いいねした商品',
        ]);
        $notLikedItem = Item::factory()->create([
            'item_name' => 'いいねしてない商品',
        ]);

        Like::factory()->create([
            'user_id' => $user->id,
            'item_id' => $likedItem->id,
        ]);

        $response = $this->actingAs($user)->get('/mylist?tab=mylist'); 

        $response->assertStatus(200);

        $response->assertSee($likedItem->item_name);

        $response->assertDontSee($notLikedItem->item_name);
    }

    public function test_sold_label_is_displayed_for_purchased_items_in_mylist()
    {
        $user = User::factory()->create();

        $item = Item::factory()->create([
            'user_id' => $user->id,
            'item_name' => 'テスト商品',
        ]);

        Sold::factory()->create([
            'user_id' => $user->id,
            'item_id' => $item->id,
        ]);

        $response = $this->actingAs($user)->get('/mylist?tab=mylist'); 
       
        $response->assertStatus(200);

        $response->assertSee('SOLD');
    }

     public function test_guest_cannot_see_any_items_in_mylist()
    {
        $response = $this->get('/mylist?tab=mylist'); 

        $response->assertDontSee('商品名'); 
    }

}
