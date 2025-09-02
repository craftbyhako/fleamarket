<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Item;
use App\Models\Sold; 
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Auth;

class PurchaseTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_purchase_item()
    {
        $user = User::factory()->create();
        $item = Item::factory()->create();

        $this->actingAs($user);


        session(['purchase_address' => [
            'postcode' => '123-4567',
            'address' => '東京都新宿区テスト町1-2-3',
            'building' => 'テストビル101',
        ]]);

        $payment = 'カード払い';

        $response = $this->post(route('purchase.store', ['item_id' => $item->id]), [
            'payment' => $payment,
        ]);

        $response->assertStatus(302);
        $response->assertRedirect(route('mylist', ['tab' => 'mylist']));
        $response->assertSessionHas('success', '購入が完了しました');

    // DBに購入情報が登録されていることを確認
        $this->assertDatabaseHas('solds', [
            'user_id' => $user->id,
            'item_id' => $item->id,
            'payment' => $payment,
            'destination_postcode' => ['123-4567'],
            'destination_address' => ['東京都新宿区テスト町1-2-3'],
            'destination_building' => ['テストビル101'],
        ]);
    }


    public function test_purchased_item_shows_sold_label_in_item_list()
    {
        $user = User::factory()->create();
        $item = Item::factory()->create();

        $this->actingAs($user)->post('/purchase', [
            'item_id' => $item->id,
            'payment' => 'カード払い',
        ]);


        $response = $this->actingAs($user)->get('mylist?tab=mylist');
        $response->assertSee('SOLD');
    }

    public function test_purchased_item_is_added_to_my_page_purchased_items()
    {
        $user = User::factory()->create();
        $item = Item::factory()->create();

        $this->actingAs($user)->post('/purchase', [
            'item_id' => $item->id,
            'payment_method' => 'カード払い',
        ]);

        $response = $this->actingAs($user)->get('/mypage?tab=bought');

        $response->assertSee($item->item_name);
    }
}