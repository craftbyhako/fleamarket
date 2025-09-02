<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use App\Models\Item;
use App\Models\Like;

class LikeTest extends TestCase
{
    use RefreshDatabase;
    
    public function test_user_can_like_item_and_like_count_increases()
    {
        $user = User::factory()->create();
        $item = Item::factory()->create([
            'item_name' => 'テスト商品',
        ]);

        $response = $this->actingAs($user)->post('/items/' . $item->id . '/like');

        $response->assertStatus(302);

        $this->assertDatabaseHas('likes', [
            'user_id' => $user->id,
            'item_id' => $item->id,
        ]);

        $item->refresh(); 
        $this->assertEquals(1, $item->likes()->count());
    }

    public function test_like_icon_changes_after_post_like()
    {
        $user = User::factory()->create();
        $item = Item::factory()->create([
            'item_name' => 'テスト商品',
        ]);

        $response = $this->actingAs($user)->post('/items/' . $item->id . '/like');

        $response->assertStatus(302); 

        $this->assertDatabaseHas('likes', [
            'user_id' => $user->id,
            'item_id' => $item->id,
        ]);

        $item->refresh();
        $this->assertEquals(1, $item->likes()->count());

        $response = $this->actingAs($user)->get('/item/' . $item->id);
        $response->assertSee('like_red.jpeg');
}

    public function test_user_can_unlike_item_and_like_count_decreases()
    {
        $user = User::factory()->create();
        $item = Item::factory()->create([
            'item_name' => 'テスト商品',
        ]);

        Like::factory()->create([
            'user_id' => $user->id,
            'item_id' => $item->id,
        ]);

        $response = $this->actingAs($user)->post('/items/' . $item->id . '/like');

        $this->assertDatabaseMissing('likes', [
            'user_id' => $user->id,
            'item_id' => $item->id,
        ]);

        $item->refresh();
        $this->assertEquals(0, $item->likes()->count());

        $response = $this->actingAs($user)->get('/item/' . $item->id);
        $response->assertStatus(200);
        $response->assertSee('like_black.jpeg');
    }

}
