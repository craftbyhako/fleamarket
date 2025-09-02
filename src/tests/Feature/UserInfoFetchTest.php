<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use App\Models\Item;
use App\Models\Sold;
use App\Models\Condition;


class UserInfoFetchTest extends TestCase
{
    use RefreshDatabase;

    public function test_profile_page_displays_user_info_and_items()
    {
        $user = User::factory()->create([
            'user_name' => 'テストユーザー',
            'profile_image' => 'profile_test.png',
        ]);

        // Condition 作成
        $condition = Condition::factory()->create();

        // 出品した商品を作成
        $ownItem = Item::factory()->create([
            'user_id' => $user->id,
            'item_name' => '出品商品1',
            'condition_id' => Condition::factory(),
            'image' => 'dummy.jpg',
            'brand' => 'brand',
            'price' => 5000,
            'description' => 'テスト商品の説明',
        ]);

        $otherUser = User::factory()->create();

        // 他人の商品も作成
        $otherItem = Item::factory()->create([
            'user_id' => $otherUser->id,
            'item_name' => '他人の商品',
            'condition_id' => Condition::factory(),
            'image' => 'dummy.jpg',
            'brand' => 'brand',
            'price' => 5000,
            'description' => 'テスト商品の説明',

        ]);

        // 購入した商品を作成
        $purchasedItem = Item::factory()->create([
             'user_id' => User::factory()->create()->id,
             'item_name' => '購入商品1',
            'image' => 'dummy.jpg',

        ]);
        Sold::factory()->create([
            'user_id' => $user->id,
            'item_id' => $purchasedItem->id,
        ]);

        $response = $this->actingAs($user)->get('/mylist?tab=mylist');

        $response->assertStatus(200);

        // ユーザー情報
        $response->assertSee('テストユーザー');
        $response->assertSee('profile_test.png');

        // 出品した商品一覧
        $response->assertSee('出品商品1');
        $response->assertDontSee('他人の商品'); 

        // 購入した商品一覧
        $response->assertSee('購入商品1');
    }
}
