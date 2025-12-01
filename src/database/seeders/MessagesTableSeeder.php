<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Sold;
use Illuminate\Support\Facades\DB;

class MessagesTableSeeder extends Seeder
{
    public function run()
    {
        $sold1 = Sold::first(); // 一番最初の取引
        $sold2 = Sold::skip(1)->first(); // 2番目の取引

        DB::table('messages')->insert([
            'sold_id' => $sold1->id,
            'user_id' => 3,
            'message' => '商品購入しました！よろしくお願いします！',
            'image' => null,
            'is_read' => false,
        ]);

        DB::table('messages')->insert([
            'sold_id' => $sold1->id,
            'user_id' => 1,
            'message' => 'ありがとうございます！発送準備しています。',
            'image' => null,
            'is_read' => false,
        ]);

        DB::table('messages')->insert([
            'sold_id' => $sold1->id,
            'user_id' => 3,
            'message' => '了解です！楽しみにしています！',
            'image' => null,
            'is_read' => false,
        ]);

        DB::table('messages')->insert([
            'sold_id' => $sold2->id,
            'user_id' => 3,
            'message' => '発送お願いします！',
            'image' => null,
            'is_read' => false,
        ]);

        DB::table('messages')->insert([
            'sold_id' => $sold2->id,
            'user_id' => 1,
            'message' => 'ありがとうございます！',
            'image' => null,
            'is_read' => false,
        ]);
    }
}
