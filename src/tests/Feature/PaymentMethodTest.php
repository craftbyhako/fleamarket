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
        $user = User::factory()->create();
        $item = Item::factory()->create([
            'item_name' => 'テスト商品',
            'price' => 1000,
        ]);

        $this->actingAs($user)
             ->withSession(['payment_method' => 'コンビニ払い']);

        $this->actingAs($user)
             ->get(route('purchase.form', [
                 'item' => $item->id,
             ]));

        $response = $this->actingAs($user)
                         ->get(route('purchase.form', ['item' => $item->id]));

       
        $response->assertStatus(200);
        $response->assertSee('コンビニ払い'); 
    }
}
