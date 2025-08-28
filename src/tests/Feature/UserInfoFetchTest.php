<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use App\Models\Item;
use App\Models\Sold;

class UserInfoFetchTest extends TestCase
{
    use RefreshDatabase;

    public function test_profile_page_displays_user_info_and_items()
    {
        // Arrange: ユーザー作成
        $user = User::factory()->create([
            'user_name' => 'テストユーザー',
            'profile_image' => 'profile_test.png',
        ]);

        // 出品した商品を作成
        $ownItem = Item::factory()->create([
            'user_id' => $user->id,
            'item_name' => '出品商品1',
        ]);

        // 他人の商品も作成
        $otherItem = Item::factory()->create([
            'item_name' => '他人の商品',
        ]);

        // 購入した商品を作成
        $purchasedItem = Item::factory()->create([
            'item_name' => '購入商品1',
        ]);
        Sold::factory()->create([
            'user_id' => $user->id,
            'item_id' => $purchasedItem->id,
        ]);

        // Act: プロフィールページを開く
        $response = $this->actingAs($user)->get('/mylist?tab=mylist'); // マイページのプロフィールタブ

        // Assert: 正しい情報が表示されている
        $response->assertStatus(200);

        // ユーザー情報
        $response->assertSee('テストユーザー');
        $response->assertSee('profile_test.png');

        // 出品した商品一覧
        $response->assertSee('出品商品1');
        $response->assertDontSee('他人の商品'); // 他人の商品は表示されない

        // 購入した商品一覧
        $response->assertSee('購入商品1');
    }
}
