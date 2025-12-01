<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RatingsTableSeeder extends Seeder
{
    public function run()
    {
        DB::table('ratings')->insert([
            [
                'target_user_id' => 1, // 評価される側（例：出品者）
                'rater_id' => 2,       // 評価する側（例：購入者）
                'score' => 5,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'target_user_id' => 2,
                'rater_id' => 1,
                'score' => 4,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
