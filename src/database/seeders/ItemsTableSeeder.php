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
            'user_id' => 3,
            'condition_id' => 1,
            'item_name' => '腕時計',
            'image' => 'storage/images/Armani+Mens+Clock.jpg',
            'brand' => 'Rolex',
            'price' => '15000',
            'description' => 'スタイリッシュなデザインのメンズ腕時計',
        ]);
        $item->categories()->attach([1,5]);

        $item = Item::create([
            'user_id' => 11,
            'condition_id' => 2,
            'item_name' => 'HDD',
            'image' => 'storage/images/HDD+Hard+Disk.jpg',
            'brand' => '西芝',
            'price' => '5000',
            'description' => '高速で信頼性の高いハードディスク',
        ]);
        $item->categories()->attach([1,5]);

        $item = Item::create([
            'user_id' => 8,
            'condition_id' => 3,
            'item_name' => '玉ねぎ３束',
            'image' => 'storage/images/onion.jpg',
            'brand' => 'なし',
            'price' => '300',
            'description' => '新鮮な玉ねぎの３束のセット',
        ]);
        $item->categories()->attach([10]);


        $item = Item::create ([
            'user_id' => 1,
            'condition_id' => 4,
            'item_name' => '革靴',
            'image' => 'storage/images/Leather+Shoes+Product+Photo.jpg',
            'brand' => '',
            'price' => '4000',
            'description' => 'クラシックなデザインの革靴',
        ]);
        $item->categories()->attach([1,5]);

        $item = Item::create([
            'user_id' => 6,
            'condition_id' => 1,
            'item_name' => 'ノートPC',
            'image' => 'storage/images/Living+Room+Laptop.jpg',
            'brand' => '',
            'price' => '45000',
            'description' => '高性能なノートパソコン',
        ]);
        $item->categories()->attach([2]);

        $item = Item::create([
            'user_id' => 10,
            'condition_id' => 2,
            'item_name' => 'マイク',
            'image' => 'storage/images/Music+Mic+4632231.jpg',
            'brand' => 'なし',
            'price' => '8000',
            'description' => '高音質のレコーディング用マイク',
        ]);
        $item->categories()->attach([2]);


        $item = Item::create([
            'user_id' => 2,
            'condition_id' => 3,
            'item_name' => 'ショルダーバッグ',
            'image' => 'storage/images/Purse+fashion+pocket.jpg',
            'brand' => '',
            'price' => '3500',
            'description' => 'おしゃれなショルダーバッグ',
        ]);
        $item->categories()->attach([1,4]);


        $item = Item::create([
            'user_id' => 12,
            'condition_id' => 4,
            'item_name' => 'タンブラー',
            'image' => 'storage/images/Tumbler+souvenir.jpg',
            'brand' => 'なし',
            'price' => '500',
            'description' => '使いやすいタンブラー',
        ]);
        $item->categories()->attach([10]);

        $item = Item::create([
            'user_id' => 7,
            'condition_id' => 1,
            'item_name' => 'コーヒーミル',
            'image' => 'storage/images/Waitress+with+Coffee+Grinder.jpg',
            'brand' => 'Starbacks',
            'price' => '4000',
            'description' => '手動のコーヒーミル',
        ]);
        $item->categories()->attach([10,11]);


        $item = Item::create([
            'user_id' => 9,
            'condition_id' => 2,
            'item_name' => 'メイクセット',
            'image' => 'storage/images/makeup.jpg',
            'brand' => '',
            'price' => '2500',
            'description' => '便利なメイクアップセット',
        ]);
        $item->categories()->attach([4,6]);

    }
}
