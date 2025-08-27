<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class LoginTest extends TestCase
{
    use RefreshDatabase;

    public function test_email_is_required()
    {
        $response = $this->get('/login');
        $response->assertStatus(200);
        
        $formData = [
            'email' => '',
            'password' => '12345678',
        ];
        
        $response = $this->post('/login', $formData);
        $response->assertSessionHasErrors([
            'email' => 'メールアドレスを入力してください',
        ]);       
    }

    public function  test_password_is_required()
    {
        $response = $this->get('/login');
        $response->assertStatus(200);
        
        $formData = [
            'email' => 'test@example.com',
            'password' => '',
        ];
        
        $response = $this->post('/login', $formData);
        $response->assertSessionHasErrors([
            'password' => 'パスワードを入力してください',
        ]);       

    }

    public function  test_invalid_input()
    {
        $response = $this->get('/login');
        $response->assertStatus(200);
        
        $formData = [
            'email' => 'notregistered@example.com',
            'password' => '12345678',
        ];
        
        $response = $this->post('/login', $formData);
        $response->assertSessionHasErrors([
            'email' => 'ログイン情報が登録されていません',

        $this->assertGuest();
        ]);       
    }

    public function test_valid_credential_login()
    {
        $response = $this->get('/login');
        $response->assertStatus(200);

        
        $user = User::factory()->create([
            'email' => 'test@example.com',
            'password' => Hash::make('12345678'),
        ]);

        $response = $this->post('/login', [
            'email' => 'test@example.com',
            'password' => '12345678',
        ]);

        $this->assertAuthenticatedAs($user);
        $response->assertSessionDoesntHaveErrors();
        $response->assertRedirect('/mylist?tab=mylist'); 

    }
    
}
