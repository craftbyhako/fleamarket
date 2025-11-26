<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Item;
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

        $item = Item::where('item_name', '腕時計')->first();

        DB::table('solds')->insert([
            'user_id' => 3,
            'item_id' => $item->id,
            'status' => null,
            'payment' => 'カード払い',
            'destination_postcode' => '111-1111',
            'destination_address' => '東京都千代田区1',
            'destination_building' => '',
        ]);
       

        $item = Item::where('item_name', 'ノートPC')->first();
        DB::table('solds')->insert([
            'user_id' => 3,
            'item_id' => $item->id,
            'status' => null,
            'payment' => 'コンビニ払い',
            'destination_postcode' => '171-7171',
            'destination_address' => '東京都千代田区17',
            'destination_building' => '',
        ]);

        
        $item = Item::where('item_name', 'メイクセット')->first();

        DB::table('solds')->insert([
            'user_id' => 3,
            'item_id' => $item->id,
            'status' => null,
            'payment' => 'コンビニ払い',
            'destination_postcode' => '100-1001',
            'destination_address' => '東京都千代田区100',
            'destination_building' => '100ビルディング',
        ]);
    }
}
