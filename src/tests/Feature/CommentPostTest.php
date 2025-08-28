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
        // Arrange: ユーザーと商品を作成
        $user = User::factory()->create();
        $item = Item::factory()->create([
            'item_name' => 'テスト商品',
        ]);

        $initialCommentCount = Comment::where('item_id', $item->id)->count();

        // Act: コメントをPOST送信
        $response = $this->actingAs($user)->post(route('comments.store'), [
            'item_id' => $item->id,
            'content' => 'これはテストコメントです。',
        ]);

        // Assert: リダイレクト（通常は商品詳細ページ）
        $response->assertStatus(302);

        // DBにコメントが保存されているか確認
        $this->assertDatabaseHas('comments', [
            'item_id' => $item->id,
            'user_id' => $user->id,
            'content' => 'これはテストコメントです。',
        ]);

        // コメント数が1件増えていることを確認
        $newCommentCount = Comment::where('item_id', $item->id)->count();
        $this->assertEquals($initialCommentCount + 1, $newCommentCount);
    }

    public function test_guest_cannot_post_comment()
    {
        // Arrange: 商品を作成
        $item = Item::factory()->create([
            'item_name' => 'テスト商品',
        ]);

        $initialCommentCount = Comment::where('item_id', $item->id)->count();

        // Act: 未認証でコメント送信
        $response = $this->post(route('comments.store'), [
            'item_id' => $item->id,
            'content' => 'ゲストコメント',
        ]);

        // Assert: ログインページへリダイレクトされる
        $response->assertRedirect(route('login'));

        // DBにコメントが保存されていないことを確認
        $this->assertDatabaseMissing('comments', [
            'item_id' => $item->id,
            'content' => 'ゲストコメント',
        ]);

        // コメント件数が増えていないこと
        $newCommentCount = Comment::where('item_id', $item->id)->count();
        $this->assertEquals($initialCommentCount, $newCommentCount);
    }

     public function test_comment_cannot_be_empty()
    {
        // Arrange: ユーザーと商品を作成
        $user = User::factory()->create();
        $item = Item::factory()->create();

        // Act: コメントを空で送信
        $response = $this->actingAs($user)->post(route('comments.store'), [
            'item_id' => $item->id,
            'content' => '', // 空コメント
        ]);

        // Assert: バリデーションエラーがセッションに存在する
        $response->assertSessionHasErrors(['content']);

        // DBにコメントが保存されていないことも確認
        $this->assertDatabaseMissing('comments', [
            'item_id' => $item->id,
            'user_id' => $user->id,
        ]);
    }

    public function test_comment_cannot_exceed_255_characters()
    {
        // Arrange: ユーザーと商品を作成
        $user = User::factory()->create();
        $item = Item::factory()->create();

        // 255文字を超えるコメントを作成
        $longComment = str_repeat('あ', 256);

        // Act: コメント送信
        $response = $this->actingAs($user)->post(route('comments.store'), [
            'item_id' => $item->id,
            'content' => $longComment,
        ]);

        // Assert: バリデーションエラーがセッションに存在する
        $response->assertSessionHasErrors(['content']);

        // DBに保存されていないことを確認
        $this->assertDatabaseMissing('comments', [
            'item_id' => $item->id,
            'user_id' => $user->id,
            'content' => $longComment,
        ]);
    }

}
