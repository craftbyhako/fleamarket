<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = [
            [
            'user_name' => 'test1',
            'email' => 'test@example.com1',
            'password' => Hash::make('password'),
            'profile_image' => '',
            'postcode' => '111-1111',
            'address' => '東京都千代田区100',
            'building' => '100ビルディング',
            ],

            [
            'user_name' => 'test2',
            'email' => 'test@example.com2',
            'password' => Hash::make('password'),
            'profile_image' => '',
            'postcode' => '222-2222',
            'address' => '東京都千代田区200',
            'building' => '200ビルディング',
            ],
        
            [
            'user_name' => 'test3',
            'email' => 'test@example.com3',
            'password' => Hash::make('password'),
            'profile_image' => '',
            'postcode' => '333-3333',
            'address' => '東京都千代田区300',
            'building' => '',
            ],
        
        ];
        
        foreach ($users as $param) {
            User::firstOrCreate(
                ['email' => $param['email']],
                $param
            );
        }
    }
}
