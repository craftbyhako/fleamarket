<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use App\Models\Item;
use App\Models\Category;
use App\Models\Condition;
use Illuminate\Support\Facades\Hash;


class ItemStoreTest extends TestCase
{
    use RefreshDatabase;

    public function test_item_can_be_saved_with_all_required_fields()
    {
        // Arrange: ユーザーとカテゴリ、商品の状態を作成
        $user = User::factory()->create([
            'user_name' => '鈴木　一郎',
            'email' => 'test@example.com',
            'password' => Hash::make('password'),
        ]);
        
        $category = Category::factory()->create(['category_name' => 'テストカテゴリ']);
        $condition = Condition::factory()->create(['condition' => '新品']);

        $itemData = [
            'item_name' => 'テスト商品',
            'brand' => 'テストブランド',
            'description' => 'テスト商品の説明です。',
            'price' => 5000,
            'category_ids' => [$category->id], // 複数選択可
            'condition_id' => $condition->id,
        ];

       
        // Act: 商品出品画面で POST
        $response = $this->actingAs($user)
                         ->post(route('item.store'), $itemData);

        // Assert: リダイレクトされること
        $response->assertStatus(302);
        $response->assertRedirect(route('items.index')); // 出品後のページ

        // DBに保存されていることを確認
        $this->assertDatabaseHas('items', [
            'item_name' => 'テスト商品',
            'brand' => 'テストブランド',
            'description' => 'テスト商品の説明です。',
            'price' => 5000,
            'condition_id' => $condition->id,
            'user_id' => $user->id,
        ]);

        // カテゴリとの紐づけも確認（中間テーブル item_category など）
        $this->assertDatabaseHas('category_item', [
            'item_id' => $item->id,
            'category_id' => $category->id,
        ]);
    }
}
