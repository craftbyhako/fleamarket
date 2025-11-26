<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Item;
use App\Models\Category;


class ItemsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $item = Item::create([
            'code' => 'CO01',
            'user_id' => 1,
            'condition_id' => 1,
            'item_name' => '腕時計',
            'image' => 'images/Armani+Mens+Clock.jpg',
            'price' => '15000',
            'description' => 'スタイリッシュなデザインのメンズ腕時計',
        ]);
        $item->categories()->attach([1,5]);

        $item = Item::create([
            'code' => 'CO02',
            'user_id' => 1,
            'condition_id' => 2,
            'item_name' => 'HDD',
            'image' => 'images/HDD+Hard+Disk.jpg',
            'price' => '5000',
            'description' => '高速で信頼性の高いハードディスク',
        ]);
        $item->categories()->attach([1,5]);

        $item = Item::create([
            'code' => 'CO03',
            'user_id' => 1,
            'condition_id' => 3,
            'item_name' => '玉ねぎ３束',
            'image' => 'images/onion.jpg',
            'price' => '300',
            'description' => '新鮮な玉ねぎの３束のセット',
        ]);
        $item->categories()->attach([10]);


        $item = Item::create ([
            'code' => 'CO04',
            'user_id' => 1,
            'condition_id' => 4,
            'item_name' => '革靴',
            'image' => 'images/Leather+Shoes+Product+Photo.jpg',
            'price' => '4000',
            'description' => 'クラシックなデザインの革靴',
        ]);
        $item->categories()->attach([1,5]);

        $item = Item::create([
            'code' => 'CO05',
            'user_id' => 1,
            'condition_id' => 1,
            'item_name' => 'ノートPC',
            'image' => 'images/Living+Room+Laptop.jpg',
            'price' => '45000',
            'description' => '高性能なノートパソコン',
        ]);
        $item->categories()->attach([2]);

        $item = Item::create([
            'code' => 'CO06',
            'user_id' => 2,
            'condition_id' => 2,
            'item_name' => 'マイク',
            'image' => 'images/Music+Mic+4632231.jpg',
            'price' => '8000',
            'description' => '高音質のレコーディング用マイク',
        ]);
        $item->categories()->attach([2]);


        $item = Item::create([
            'code' => 'CO07',
            'user_id' => 2,
            'condition_id' => 3,
            'item_name' => 'ショルダーバッグ',
            'image' => 'images/Purse+fashion+pocket.jpg',
            'price' => '3500',
            'description' => 'おしゃれなショルダーバッグ',
        ]);
        $item->categories()->attach([1,4]);


        $item = Item::create([
            'code' => 'CO08',
            'user_id' => 2,
            'condition_id' => 4,
            'item_name' => 'タンブラー',
            'image' => 'images/Tumbler+souvenir.jpg',
            'price' => '500',
            'description' => '使いやすいタンブラー',
        ]);
        $item->categories()->attach([10]);

        $item = Item::create([
            'code' => 'CO09',
            'user_id' => 2,
            'condition_id' => 1,
            'item_name' => 'コーヒーミル',
            'image' => 'images/Waitress+with+Coffee+Grinder.jpg',
            'price' => '4000',
            'description' => '手動のコーヒーミル',
        ]);
        $item->categories()->attach([10,11]);


        $item = Item::create([
            'code' => 'CO10',
            'user_id' => 2,
            'condition_id' => 2,
            'item_name' => 'メイクセット',
            'image' => 'images/makeup.jpg',
            'price' => '2500',
            'description' => '便利なメイクアップセット',
        ]);
        $item->categories()->attach([4,6]);

    }
}
