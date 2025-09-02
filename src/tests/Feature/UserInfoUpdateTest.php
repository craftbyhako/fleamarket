<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;


class UserInfoUpdateTest extends TestCase
{
    use RefreshDatabase;

    public function test_profile_initial_values_are_displayed()
    {
        $user = User::factory()->create([
            'user_name' => 'テストユーザー',
            'profile_image' => 'profile_test.png',
            'postcode' => '123-4567',
            'address' => '東京都渋谷区1-1-1',
            'building' => 'テストビル101',
        ]);

        $response = $this->actingAs($user)->get('/mypage/profile'); 

        $response->assertStatus(200);

        // ユーザー名
        $response->assertSee('テストユーザー');

        // プロフィール画像
        $response->assertSee('profile_test.png');

        // 郵便番号
        $response->assertSee('123-4567');

        // 住所
        $response->assertSee('東京都渋谷区1-1-1');

        // 建物
        $response->assertSee('テストビル101');
    }
}
