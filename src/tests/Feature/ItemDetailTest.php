<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use App\Models\Item;
use App\Models\Category;
use App\Models\Condition;
use App\Models\Comment;

class ItemDetailTest extends TestCase
{
    use RefreshDatabase;

    public function test_item_detail_page_displays_all_information()
    {
       $user = User::factory()->create([
            'user_name' => '出品者太郎',
        ]);

        $condition = Condition::factory()->create([
            'condition' => '新品',
        ]);

        $item = Item::factory()->create([
            'user_id' => $user->id,
            'item_name' => 'テスト商品',
            'brand' => 'テストブランド',
            'price' => 12345,
            'description' => 'これはテスト用の商品説明です。',
            'condition_id' => $condition->id,
            'image' => 'test.jpg',
        ]);

        $category = Category::factory()->create([
            'category_name' => 'テストカテゴリ',
        ]);

        $item->categories()->attach($category->id);

        $comment = Comment::factory()->create([
            'item_id' => $item->id,
            'user_id' => $user->id,
            'content' => 'これはテストコメントです。',
        ]);

        $response = $this->get('/item/' . $item->id);

        $response->assertStatus(200);

        $response->assertSee($item->item_name);
        $response->assertSee($item->brand);
        $response->assertSee(number_format($item->price));
        $response->assertSee($item->description);
        $response->assertSee($category->category_name);
        $response->assertSee($condition->condition);
        $response->assertSee($comment->content);

        $response->assertSee('storage/' . $item->image);
    }

    public function test_item_detail_displays_multiple_categories()
    {
        $user = User::factory()->create();

        $item = Item::factory()->create([
            'user_id' => $user->id,
            'item_name' => 'テスト商品',
        ]);

        $category1 = Category::factory()->create(['category_name' => 'カテゴリA']);
        $category2 = Category::factory()->create(['category_name' => 'カテゴリB']);

        $item->categories()->attach([$category1->id, $category2->id]);

        $response = $this->get('/item/' . $item->id);

        $response->assertStatus(200);

        $response->assertSee($category1->category_name);
        $response->assertSee($category2->category_name);
    }
}
