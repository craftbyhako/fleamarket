<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use App\Models\Item;
use App\Models\Comment;

class CommentPostTest extends TestCase
{
    use RefreshDatabase;
    
    public function test_user_can_post_comment_and_comment_count_increases()
    {
        $user = User::factory()->create();
        $item = Item::factory()->create([
            'item_name' => 'テスト商品',
        ]);

        $initialCommentCount = Comment::where('item_id', $item->id)->count();

        $response = $this->actingAs($user)->post(route('comments.store'), [
            'item_id' => $item->id,
            'content' => 'これはテストコメントです。',
        ]);

        $response->assertStatus(302);

        $this->assertDatabaseHas('comments', [
            'item_id' => $item->id,
            'user_id' => $user->id,
            'content' => 'これはテストコメントです。',
        ]);

        $newCommentCount = Comment::where('item_id', $item->id)->count();
        $this->assertEquals($initialCommentCount + 1, $newCommentCount);
    }

    public function test_guest_cannot_post_comment()
    {
        $item = Item::factory()->create([
            'item_name' => 'テスト商品',
        ]);

        $initialCommentCount = Comment::where('item_id', $item->id)->count();

        $response = $this->post(route('comments.store'), [
            'item_id' => $item->id,
            'content' => 'ゲストコメント',
        ]);

        $response->assertRedirect(route('login'));

        $this->assertDatabaseMissing('comments', [
            'item_id' => $item->id,
            'content' => 'ゲストコメント',
        ]);

        $newCommentCount = Comment::where('item_id', $item->id)->count();
        $this->assertEquals($initialCommentCount, $newCommentCount);
    }

     public function test_comment_cannot_be_empty()
    {
        $user = User::factory()->create();
        $item = Item::factory()->create();

        $response = $this->actingAs($user)->post(route('comments.store'), [
            'item_id' => $item->id,
            'content' => '', 
        ]);

        $response->assertSessionHasErrors(['content']);

        $this->assertDatabaseMissing('comments', [
            'item_id' => $item->id,
            'user_id' => $user->id,
        ]);
    }

    public function test_comment_cannot_exceed_255_characters()
    {
        $user = User::factory()->create();
        $item = Item::factory()->create();

        $longComment = str_repeat('あ', 256);

        $response = $this->actingAs($user)->post(route('comments.store'), [
            'item_id' => $item->id,
            'content' => $longComment,
        ]);

        $response->assertSessionHasErrors(['content']);

        $this->assertDatabaseMissing('comments', [
            'item_id' => $item->id,
            'user_id' => $user->id,
            'content' => $longComment,
        ]);
    }

}
