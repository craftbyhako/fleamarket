<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\DB;


class SoldsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
       $param = [
            'user_id' => 1,
            'item_id' => 5,
            'payment' => 'カード',
            'destination_postcode' => '111-1111',
            'destination_address' => '東京都千代田区1',
            'destination_building' => '',
        ];
        DB::table('solds')->insert($param);
       
        $param = [
            'user_id' => 17,
            'item_id' => 16,
            'payment' => 'コンビニ',
            'destination_postcode' => '171-7171',
            'destination_address' => '東京都千代田区17',
            'destination_building' => '',
        ];
        DB::table('solds')->insert($param);

        $param = [
            'user_id' => 9,
            'item_id' => 18,
            'payment' => 'コンビニ',
            'destination_postcode' => '100-1001',
            'destination_address' => '東京都千代田区100',
            'destination_building' => '100ビルディング',
        ];
        DB::table('solds')->insert($param);

    }
}
