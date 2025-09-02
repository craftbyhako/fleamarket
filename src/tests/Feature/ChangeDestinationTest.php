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
        $user = User::factory()->create();
        $item = Item::factory()->create();

        $addressData = [
            'destination_postcode' => '123-4567',
            'destination_address' => '東京都渋谷区1-1-1',
            'destination_building' => 'テストビル101',
        ];

        $this->actingAs($user)
            ->patch(route('purchase.updateDestination', ['item_id' => $item->id]), $addressData)
            ->assertRedirect()
            ->assertSessionHas('purchase_address', [
                'postcode' => '123-4567',
                'address' => '東京都渋谷区1-1-1',
                'building' => 'テストビル101',
                ]);

        $response = $this->actingAs($user)
            ->get(route('purchase.form', ['item' => $item->id]));

        $response->assertStatus(200);
        $response->assertSee('123-4567');
        $response->assertSee('東京都渋谷区1-1-1');
        $response->assertSee('テストビル101');
    }

    public function test_purchased_item_has_correct_destination_address()
    {
        
        $user = User::factory()->create();
        $item = Item::factory()->create();

        $addressData = [
            'postcode' => '123-4567',
            'address' => '東京都渋谷区1-1-1',
            'building' => 'テストビル101',
        ];

        $this->actingAs($user)
             ->withSession(['purchase_address' => $addressData])
             ->post(route('purchase.store', ['item_id' => $item->id]), [
                 'payment' => 'credit_card',
             ]);

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
