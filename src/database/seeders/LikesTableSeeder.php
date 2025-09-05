<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Item;



class LikesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {        
        $item = Item::where('item_name', 'メイクセット')->first();
        DB::table('likes')->insert([
            'user_id' => 1,
            'item_id' => $item->id,
        ]);
        
        $item = Item::where('item_name', 'マイク')->first();
        DB::table('likes')->insert([
            'user_id' => 1,
            'item_id' => $item->id,
        ]);

        $item = Item::where('item_name', 'ノートPC')->first();
        DB::table('likes')->insert([
            'user_id' => 3,
            'item_id' => $item->id,
        ]);
        
        $item = Item::where('item_name', 'ショルダーバッグ')->first();
        DB::table('likes')->insert([
            'user_id' => 2,
            'item_id' => $item->id,
        ]);

        $item = Item::where('item_name', 'コーヒーミル')->first();
        DB::table('likes')->insert([
            'user_id' => 2,
            'item_id' => $item->id,
        ]);

        $item = Item::where('item_name', 'タンブラー')->first();
        DB::table('likes')->insert([
            'user_id' => 4,
            'item_id' => $item->id,
        ]);

        $item = Item::where('item_name', 'タンブラー')->first();
        DB::table('likes')->insert([
            'user_id' => 3,
            'item_id' => $item->id,
        ]);
    }
}
