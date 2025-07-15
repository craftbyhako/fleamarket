<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $param = [
            'user_name' => 'テスト１００',
            'email' => 'test@email.com100',
            'password' => Hash::make('password'),
            'image' => '',
            'postcode' => '100-1001',
            'address' => '東京都千代田区100',
            'building' => '100ビルディング',
        ];
        DB::table('users')->insert($param);

        $param = [
            'user_name' => 'テスト１０１',
            'email' => 'test@email.com101',
            'password' => Hash::make('password'),
            'image' => '',
            'postcode' => '101-1011',
            'address' => '東京都千代田区101',
            'building' => '101ビルディング',
        ];
        DB::table('users')->insert($param);
        
        $param = [
            'user_name' => 'テスト１０２',
            'email' => 'test@email.com102',
            'password' => Hash::make('password'),
            'image' => '',
            'postcode' => '102-1021',
            'address' => '東京都千代田区102',
            'building' => '',
        ];
        DB::table('users')->insert($param);
        
        $param = [
            'user_name' => 'テスト１０３',
            'email' => 'test@email.com103',
            'password' => Hash::make('password'),
            'image' => '',
            'postcode' => '103-1031',
            'address' => '東京都千代田区103',
            'building' => '103ビルディング',
        ];
        DB::table('users')->insert($param);

    }
}
