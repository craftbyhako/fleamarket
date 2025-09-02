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
use Illuminate\Http\UploadedFile;



class ItemStoreTest extends TestCase
{
    use RefreshDatabase;

    public function test_item_can_be_saved_with_all_required_fields()
    {
        $user = User::factory()->create([
            'user_name' => '鈴木　一郎',
            'email' => 'test@example.com',
            'password' => Hash::make('password'),
        ]);
        
        $category = Category::factory()->create(['category_name' => 'テストカテゴリ']);
        $condition = Condition::factory()->create(['condition' => '良好']);

        $itemData = [
            'item_name' => 'テスト商品',
            'brand' => 'テストブランド',
            'description' => 'テスト商品の説明です。',
            'price' => 5000,
            'categories' => [$category->id], 
            'condition_id' => $condition->id,
            'image'        => UploadedFile::fake()->create('dummy.jpg', 10),
        ];

       
        $response = $this->actingAs($user)
                         ->post(route('item.store'), $itemData);
        
        
        $response->assertStatus(302);
        $response->assertRedirect('/sell'); 

        $this->assertDatabaseHas('items', [
            'item_name' => 'テスト商品',
            'brand' => 'テストブランド',
            'description' => 'テスト商品の説明です。',
            'price' => 5000,
            'condition_id' => $condition->id,
            'user_id' => $user->id,
        ]);

        $item = Item::first();

        $this->assertNotEmpty($item->image);


        $this->assertDatabaseHas('category_item', [
            'item_id' => $item->id,
            'category_id' => $category->id,
        ]);
    }
}
