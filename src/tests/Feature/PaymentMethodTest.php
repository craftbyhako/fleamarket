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

        // 支払い方法をセッションにセット
        $this->actingAs($user)
             ->withSession(['payment_method' => 'コンビニ払い']);

          // 支払い方法をセッションにセット
        $this->actingAs($user)
             ->get(route('purchase.form', [
                 'item' => $item->id,
             ]));

        // Act: 購入フォームを開く
        $response = $this->actingAs($user)
                         ->get(route('purchase.form', ['item' => $item->id]));

        // Assert: 画面に選択した支払い方法が反映されていることを確認
        $response->assertStatus(200);
        $response->assertSee('コンビニ払い'); // Blade 上に表示される文字列
    }
}
