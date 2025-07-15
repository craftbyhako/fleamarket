<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;


class ConditionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $conditions = [
            ['condition' => '良好'],
            ['condition' => '目立った傷や汚れなし'],
            ['condition' => 'やや傷や汚れあり'],
            ['condition' => '状態が悪い'],
           
        ];
        DB::table('conditions')->insert($conditions);

        // $param = [
        //     'condition' => '良好',
        // ];
        // DB::table('conditions')->insert($param);
        
        // $param = [
        //     'condition' => '目立った傷や汚れなし',
        // ];
        // DB::table('conditions')->insert($param);
        
        // $param = [
        //     'condition' => 'やや傷や汚れあり',
        // ];
        // DB::table('conditions')->insert($param);
        
        // $param = [
        //     'condition' => '状態が悪い',
        // ];
        // DB::table('conditions')->insert($param);

    }
}
