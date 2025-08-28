<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use App\Models\Item;
use App\Models\Sold;

class PurchaseTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_purchase_item()
    {
        // Arrange: ユーザーと商品を作成
        $user = User::factory()->create();
        $item = Item::factory()->create([
            'item_name' => 'テスト商品',
            'price' => 1000,
        ]);

        // Act: ログイン状態で購入フォームから購入ボタンを押下
        $response = $this->actingAs($user)->post(route('purchase.complete', ['item' => $item->id]), [
            // 必要な購入情報をフォームと同じキーで送信
            'item_id' => $item->id,
            'payment_method' => 'credit_card',
            'address' => '東京都渋谷区1-1-1',
        ]);

        // Assert: リダイレクトされる（購入完了ページ想定）
        $response->assertStatus(302);
        $response->assertRedirect(route('purchase.thanks')); // 購入完了ページにリダイレクト

        // DBに購入情報が登録されていることを確認
        $this->assertDatabaseHas('solds', [
            'user_id' => $user->id,
            'item_id' => $item->id,
        ]);

        // 商品が購入済みとして更新されている場合は確認
        $item->refresh();
        $this->assertTrue($item->is_sold); // フラグがある場合
    }

     public function test_purchased_item_shows_sold_label_in_item_list()
    {
        // Arrange: ユーザーと商品を作成
        $user = User::factory()->create();
        $item = Item::factory()->create([
            'item_name' => 'テスト商品',
        ]);

        // Act: ログイン状態で購入処理を行う
        $this->actingAs($user)->post(route('purchase.complete', ['item' => $item->id]), [
            'item_id' => $item->id,
            'payment_method' => 'credit_card',
            'address' => '東京都渋谷区1-1-1',
        ]);

        // DBに購入情報が登録されていることを確認（任意）
        $this->assertDatabaseHas('solds', [
            'user_id' => $user->id,
            'item_id' => $item->id,
        ]);

        // 商品一覧ページを取得
        $response = $this->get('/items'); // 商品一覧ページURLに変更

        $response->assertStatus(200);

        // 購入済み商品に「Sold」が表示されているか確認
        $response->assertSee('Sold');
        $response->assertSee($item->item_name);
    }

    public function test_purchased_item_is_added_to_my_page_purchased_items()
    {
        // Arrange: ユーザーと商品を作成
        $user = User::factory()->create();
        $item = Item::factory()->create([
            'item_name' => 'テスト商品',
        ]);

        // Act: ログイン状態で購入処理
        $this->actingAs($user)->post(route('purchase.complete', ['item' => $item->id]), [
            'item_id' => $item->id,
            'payment_method' => 'credit_card',
            'address' => '東京都渋谷区1-1-1',
        ]);

        // DBに購入情報が登録されていることを確認
        $this->assertDatabaseHas('solds', [
            'user_id' => $user->id,
            'item_id' => $item->id,
        ]);

        // マイページの購入済み商品タブを取得
        $response = $this->actingAs($user)->get('/mylist?tab=purchased'); // 購入済みタブURL

        $response->assertStatus(200);

        // 購入済み商品が表示されていることを確認
        $response->assertSee($item->item_name);
        $response->assertSee('Sold'); // ラベルが表示される場合
    }
}
