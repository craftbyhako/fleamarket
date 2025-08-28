<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use App\Models\Item;
use App\Models\Sold;



class ChangeDestinationTest extends TestCase
{
    use RefreshDatabase;

    public function test_session_address_is_reflected_in_purchase_page()
    {
        // Arrange: ユーザーと商品を作成
        $user = User::factory()->create([
            'postcode' => '000-0000',
            'address' => '旧住所',
            'building' => '旧ビル',
        ]);
        $item = Item::factory()->create();

        $addressData = [
            'destination_postcode' => '123-4567',
            'destination_address' => '東京都渋谷区1-1-1',
            'destination_building' => 'テストビル101',
        ];

        // Act: 配送先住所をセッションに登録
        $response = $this->actingAs($user)
                         ->withSession([])
                         ->post(route('purchase.updateDestination', ['item' => $item->id]), $addressData);

        // Assert: セッションに保存されていることを確認
        $this->assertEquals(session('purchase_address.postcode'), '123-4567');
        $this->assertEquals(session('purchase_address.address'), '東京都渋谷区1-1-1');
        $this->assertEquals(session('purchase_address.building'), 'テストビル101');

        // 商品購入画面を開き、住所が反映されていることを確認
        $response = $this->actingAs($user)
                         ->withSession(session()->all())
                         ->get(route('purchase.form', ['item' => $item->id]));

        $response->assertStatus(200);
        $response->assertSee('123-4567');
        $response->assertSee('東京都渋谷区1-1-1');
        $response->assertSee('テストビル101');
    }

    public function test_purchased_item_has_correct_destination_address()
    {
        // Arrange: ユーザーと商品を作成
        $user = User::factory()->create();
        $item = Item::factory()->create();

        // 送付先住所データ
        $addressData = [
            'postcode' => '123-4567',
            'address' => '東京都渋谷区1-1-1',
            'building' => 'テストビル101',
        ];

        // Act: セッションに住所を登録
        $this->actingAs($user)
             ->withSession(['purchase_address' => $addressData])
             ->post(route('purchase.store', ['item_id' => $item->id]), [
                 'payment' => 'credit_card',
             ]);

        // Assert: Soldテーブルに正しく保存されていることを確認
        $this->assertDatabaseHas('solds', [
            'user_id' => $user->id,
            'item_id' => $item->id,
            'destination_postcode' => '123-4567',
            'destination_address' => '東京都渋谷区1-1-1',
            'destination_building' => 'テストビル101',
            'payment' => 'credit_card',
        ]);
    }
}
