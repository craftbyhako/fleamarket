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

        $hit1 = Item::factory()->create(['item_name' => '赤いリンゴ']);
        $hit2 = Item::factory()->create(['item_name' => '青いリンゴ']);
        $miss  = Item::factory()->create(['item_name' => 'みかん']);

        $response = $this->get('/?keyword=りんご');

        $response->assertStatus(200);

        $response->assertSee($hit1->item_name);
        $response->assertSee($hit2->item_name);

        $response->assertDontSee($miss->name);
    }

    public function test_search_keyword_is_preserved_after_redirect_to_mylist()
    {
        $user = User::factory()->create();

        $hit1 = Item::factory()->create([
            'item_name' => '赤いリンゴ',
            'user_id' => $user->id, 
        ]);

        $hit2 = Item::factory()->create([
            'item_name' => '青いリンゴ',
            'user_id' => $user->id,
        ]);

        $miss = Item::factory()->create([
            'item_name' => 'みかん',
            'user_id' => $user->id, 
        ]);

        $response = $this->actingAs($user)->get('/?keyword=りんご');
       
        $response->assertStatus(302);
        $response->assertRedirect('/mylist?tab=mylist');

        $response = $this->actingAs($user)->get('/mylist?tab=mylist&keyword=りんご');
        $response->assertStatus(200);
        $response->assertSee('赤いリンゴ');
        $response->assertSee('青いリンゴ');
        $response->assertDontSee('みかん');

        $response = $this->actingAs($user)->get('/mylist?keyword=リンゴ');
        $response->assertStatus(200);

        $response->assertSee('value="リンゴ"', false);
    }
}
