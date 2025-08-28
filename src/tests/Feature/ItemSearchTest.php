<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Item;
use App\Models\User;



class ItemSearchTest extends TestCase
{
    use RefreshDatabase;
    
    public function test_search_returns_partial_matches()
    {

        $hit1 = Item::factory()->create(['name' => '赤いリンゴ']);
        $hit2 = Item::factory()->create(['name' => '青いリンゴ']);
        $miss  = Item::factory()->create(['name' => 'みかん']);

        $response = $this->get('/items?keyword=りんご');

        $response->assertStatus(200);

        $response->assertSee($hit1->name);
        $response->assertSee($hit2->name);

        $response->assertDontSee($miss->name);
    }

    public function test_search_keyword_is_preserved_after_redirect_to_mylist()
    {
        $user = User::factory()->create();

        Item::factory()->create(['name' => '赤いリンゴ']);
        Item::factory()->create(['name' => '青いリンゴ']);
        Item::factory()->create(['name' => 'みかん']);

        $response = $this->actingAs($user)->get('/items?keyword=リンゴ');
        $response->assertStatus(200);

        $response->assertSee('赤いリンゴ');
        $response->assertSee('青いリンゴ');
        $response->assertDontSee('みかん');

        $response = $this->actingAs($user)->get('/mylist?keyword=リンゴ');
        $response->assertStatus(200);

        $response->assertSee('value="リンゴ"', false);
    }
}
