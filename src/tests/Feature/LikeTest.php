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
        // Arrange: ユーザーと商品を作成
        $user = User::factory()->create();
        $item = Item::factory()->create([
            'item_name' => 'テスト商品',
        ]);

        // Act: ログイン状態でいいねボタンを押下（POSTリクエスト）
        $response = $this->actingAs($user)->post('/items/' . $item->id . '/like');

        // Assert: リダイレクト（通常は詳細ページに戻る想定）
        $response->assertStatus(302);

        // DBにLikeが登録されているか確認
        $this->assertDatabaseHas('likes', [
            'user_id' => $user->id,
            'item_id' => $item->id,
        ]);

        // いいね数が1になっていることを確認
        $item->refresh(); // 最新状態を取得
        $this->assertEquals(1, $item->likes()->count());
    }

    public function test_like_icon_changes_after_post_like()
    {
        $user = User::factory()->create();
        $item = Item::factory()->create([
            'item_name' => 'テスト商品',
        ]);

    // Like ボタン押下（POST）
        $response = $this->actingAs($user)->post('/items/' . $item->id . '/like');

        $response->assertStatus(302); // リダイレクト

    // DB に Like が登録されているか確認
        $this->assertDatabaseHas('likes', [
            'user_id' => $user->id,
            'item_id' => $item->id,
        ]);

    // likes_count が増えているか確認
        $item->refresh();
        $this->assertEquals(1, $item->likes()->count());

    // レスポンス HTML にアイコン画像パスが含まれているか確認（押下後は赤アイコンになる想定）
        $response = $this->actingAs($user)->get('/item/' . $item->id);
        $response->assertSee('like_red.jpeg');
}

    public function test_user_can_unlike_item_and_like_count_decreases()
    {
        // Arrange: ユーザーと商品を作成
        $user = User::factory()->create();
        $item = Item::factory()->create([
            'item_name' => 'テスト商品',
        ]);

        // 既にLikeがある状態を作成
        Like::factory()->create([
            'user_id' => $user->id,
            'item_id' => $item->id,
        ]);

        // Act: ログイン状態でいいねボタンを押下（解除）
        $response = $this->actingAs($user)->post('/items/' . $item->id . '/like');

        // Assert: DBからLikeが削除されているか
        $this->assertDatabaseMissing('likes', [
            'user_id' => $user->id,
            'item_id' => $item->id,
        ]);

        // likes_count が減っているか確認
        $item->refresh();
        $this->assertEquals(0, $item->likes()->count());

        // レスポンスHTMLで黒アイコンが表示されていることを確認
        $response = $this->actingAs($user)->get('/item/' . $item->id);
        $response->assertStatus(200);
        $response->assertSee('like_black.jpeg');
    }

}
