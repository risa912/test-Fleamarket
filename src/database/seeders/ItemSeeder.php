<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ItemSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        DB::table('items')->insert([
            [
                'name' => '腕時計',
                'price' => 15000,
                'brand' => 'Rolex',
                'image' => 'items/ArmaniMensClock.jpg',
                'description' => 'スタイリッシュなデザインのメンズ腕時計',
                'condition_id' => 1,
            ],
            [
                'name' => 'HDD',
                'price' => 5000, 
                'brand' => '西芝',
                'image' => 'items/HDDHardDisk.jpg',
                'description' => '高速で信頼性の高いハードディスク',
                'condition_id' => 2,
            ],
            [
                'name' => '玉ねぎ3束',
                'price' => 300,
                'brand' => 'なし',
                'image' => 'items/Onions3.jpg',
                'description' => '新鮮な玉ねぎ3束のセット',
                'condition_id' => 3,
            ],
            [
                'name' => '革靴',
                'price' => 4000, 
                'brand' => '',
                'image' => 'items/LeatherShoes.jpg',
                'description' => 'クラシックなデザインの革靴',
                'condition_id' => 4,
            ],
            [
                'name' => 'ノートPC',
                'price' => 45000,
                'brand' => '',
                'image' => 'items/Laptop.jpg',
                'description' => '高性能なノートパソコン',
                'condition_id' => 1,
            ],
            [
                'name' => 'マイク',
                'price' => 8000, 
                'brand' => 'なし',
                'image' => 'items/Mic.jpg',
                'description' => '高音質なレコーディング用マイク',
                'condition_id' => 2,
            ],
            [
                'name' => 'ショルダーバッグ',
                'price' => 3500, 
                'brand' => '',
                'image' => 'items/ShoulderBag.jpg',
                'description' => 'おしゃれなショルダーバッグ',
                'condition_id' => 3,
            ],
            [
                'name' => 'タンブラー',
                'price' => 500,
                'brand' => 'なし',
                'image' => 'items/Tumbler.jpg',
                'description' => '使いやすいタンブラー',
                'condition_id' => 4,
            ],
            [
                'name' => 'コーヒーミル',
                'price' => 4000, 
                'brand' => 'Starbacks',
                'image' => 'items/CoffeeMill.jpg',
                'description' => '手動のコーヒーミル',
                'condition_id' => 1,
            ],
            [
                'name' => 'メイクセット',
                'price' => 4000, 
                'brand' => '',
                'image' => 'items/MakeupSet.jpg',
                'description' => '便利なメイクアップセット',
                'condition_id' => 2,
            ],
        ]);
    }
}
