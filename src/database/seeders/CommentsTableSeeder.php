<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Item;

class CommentsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $item = Item::where('item_name', '腕時計')->first();
        DB::table('comments')->insert([
            'user_id' => 2,
            'item_id' => $item->id,
            'content' => '良品ですね',
        ]);
        

        $item = Item::where('item_name', 'HDD')->first();
        DB::table('comments')->insert([
            'user_id' => 3,
            'item_id' => $item->id,
            'content' => '美品ですね',
        ]);
       

        $item = Item::where('item_name', 'メイクセット')->first();
        DB::table('comments')->insert([
            'user_id' => 3,
            'item_id' => $item->id,
            'content' => 'ほしいです',
        ]);


        $item = Item::where('item_name', 'コーヒーミル')->first();
        DB::table('comments')->insert([
            'user_id' => 1,
            'item_id' => $item->id,
            'content' => '良品ですね',
        ]);

       
        $item = Item::where('item_name', '革靴')->first();
        DB::table('comments')->insert([
            'user_id' => 3,
            'item_id' => $item->id,
            'content' => '美品ですね',
        ]);
        
    }
}
