<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class RegisterTest extends TestCase
{
    use RefreshDatabase;

    public function test_name_is_required()
    {
        $response = $this->get('/register');
        $response->assertStatus(200);

        $formData = [
            'user_name' => '',
            'email' => 'test@example.com',
            'password' => '12345678',
            'password_confirmation' => '12345678', 
        ];

        $response = $this->post('/register', $formData);

        $response->assertSessionHasErrors([
            'user_name' => 'お名前を入力してください'
        ]);
    }

    public function test_email_is_required()
    {
        $response = $this->get('/register');
        $response->assertStatus(200);

        $formData = [
            'user_name' => '鈴木　一郎',
            'email' => '',
            'password' => '12345678',
            'password_confirmation' => '12345678', 
        ];

        $response = $this->post('/register', $formData);

        $response->assertSessionHasErrors([
            'email' => 'メールアドレスを入力してください'
        ]);
    }

    public function test_password_is_required()
    {
        $response = $this->get('/register');
        $response->assertStatus(200);

        $formData = [
            'user_name' => '鈴木　一郎',
            'email' => 'test@example.com',
            'password' => '',
            'password_confirmation' => '12345678', 
        ];

        $response = $this->post('/register', $formData);

        $response->assertSessionHasErrors([
            'password' => 'パスワードを入力してください'
        ]);
    }

    public function test_password_8characters()
    {
        $response = $this->get('/register');
        $response->assertStatus(200);

        $formData = [
            'user_name' => '鈴木　一郎',
            'email' => 'test@example.com',
            'password' => '123',
            'password_confirmation' => '123', 
        ];

        $response = $this->post('/register', $formData);

        $response->assertSessionHasErrors([
            'password' => 'パスワードは８文字以上で入力してください'
        ]);
    }

    public function test_password_must_match()
    {
        $response = $this->get('/register');
        $response->assertStatus(200);

        $formData = [
            'user_name' => '鈴木　一郎',
            'email' => 'test@example.com',
            'password' => '12345678',
            'password_confirmation' => '87654321', 
        ];

        $response = $this->post('/register', $formData);

        $response->assertSessionHasErrors([
            'password' => 'パスワードと一致しません'
        ]);
    }

    public function test_register_redirect_profile()
    {
        $formData = [
            'user_name' => 'test1' ,
            'email' => 'test@example.com',
            'password' => '12345678',
            'password_confirmation' => '12345678',
        ];

        $response = $this->post('/register', $formData);

        $this->assertDatabaseHas('users',
         [
            'user_name' => 'test1',
            'email' => 'test@example.com'
        ]);

        $response->assertRedirect('/mypage/profile/create');

         // 実際に認証状態になっていることを確認
        $this->assertAuthenticated();
    }

}
