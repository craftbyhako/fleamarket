<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use App\Models\Item;
use App\Models\Purchase;

class PaymentMethodTest extends TestCase
{
    use RefreshDatabase;

   public function test_selected_payment_method_is_reflected_in_subtotal()
    {
        // Arrange: ユーザーと商品を作成
        $user = User::factory()->create();
        $item = Item::factory()->create([
            'item_name' => 'テスト商品',
            'price' => 1000,
        ]);

        // 小計画面や購入フォームに必要なデータを準備
        $purchaseData = [
            'item_id' => $item->id,
            'payment_method' => 'credit_card', // 選択した支払い方法
            'quantity' => 1,
        ];

        // Act: 支払い方法を選択してPOST
        $response = $this->actingAs($user)->post(route('purchase.subtotal'), $purchaseData);

        // Assert: リダイレクトされる（小計画面）
        $response->assertStatus(200); // または assertRedirect() で小計画面URLを確認

        // レスポンスに選択した支払い方法が表示されていることを確認
        $response->assertSee('クレジットカード'); // bladeに表示される文字列
    }
}
