<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;


class LikesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {        
        $param = [
            'user_id' => 6,
            'item_id' => 19,
        ];
        DB::table('likes')->insert($param);
        
        $param = [
            'user_id' => 1,
            'item_id' => 6,
        ];
        DB::table('likes')->insert($param);

        $param = [
            'user_id' => 3,
            'item_id' => 5,
        ];
        DB::table('likes')->insert($param);

        $param = [
            'user_id' => 6,
            'item_id' => 15,
        ];
        DB::table('likes')->insert($param);

        $param = [
            'user_id' => 2,
            'item_id' => 14,
        ];
        DB::table('likes')->insert($param);

        $param = [
            'user_id' => 12,
            'item_id' => 8,
        ];
        DB::table('likes')->insert($param);

        $param = [
            'user_id' => 18,
            'item_id' => 19,
        ];
        DB::table('likes')->insert($param);

        $param = [
            'user_id' => 19,
            'item_id' => 16,
        ];
        DB::table('likes')->insert($param);

        $param = [
            'user_id' => 19,
            'item_id' => 8,
        ];
        DB::table('likes')->insert($param);

        $param = [
            'user_id' => 19,
            'item_id' => 15,
        ];
        DB::table('likes')->insert($param);

        $param = [
            'user_id' => 7,
            'item_id' => 7,
        ];
        DB::table('likes')->insert($param);

    }
}
