<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;


class CommentsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $param = [
            'user_id' => 11,
            'item_id' => 5,
            'content' => '良品ですね',
        ];
        DB::table('comments')->insert($param);
        $param = [
            'user_id' => 6,
            'item_id' => 5,
            'content' => '美品ですね',
        ];
        DB::table('comments')->insert($param);
        $param = [
            'user_id' => 6,
            'item_id' => 7,
            'content' => 'ほしいです',
        ];
        DB::table('comments')->insert($param);
        $param = [
            'user_id' => 6,
            'item_id' => 8,
            'content' => '良品ですね',
        ];
        DB::table('comments')->insert($param);
        $param = [
            'user_id' => 11,
            'item_id' => 14,
            'content' => '美品ですね',
        ];
        DB::table('comments')->insert($param);
        $param = [
            'user_id' => 10,
            'item_id' => 15,
            'content' => '最短発送はいつですか',
        ];
        DB::table('comments')->insert($param);
        $param = [
            'user_id' => 12,
            'item_id' => 15,
            'content' => '色違いはありますか？',
        ];
        DB::table('comments')->insert($param);
        $param = [
            'user_id' => 19,
            'item_id' => 16,
            'content' => '良品ですね',
        ];
        DB::table('comments')->insert($param);
        $param = [
            'user_id' => 1,
            'item_id' => 17,
            'content' => '色違いはありますか',
        ];
        DB::table('comments')->insert($param);
        $param = [
            'user_id' => 1,
            'item_id' => 18,
            'content' => '最短発送はいつですか？',
        ];
        DB::table('comments')->insert($param);
        $param = [
            'user_id' => 8,
            'item_id' => 19,
            'content' => '良品ですね',
        ];
        DB::table('comments')->insert($param);
        $param = [
            'user_id' => 2,
            'item_id' => 19,
            'content' => '貴重な商品ですね',
        ];
        DB::table('comments')->insert($param);


    }
}
