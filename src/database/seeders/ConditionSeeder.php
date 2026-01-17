<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ConditionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $conditions = [
            "良好",
            "目立った汚れなし",
            "やや汚れあり",
            "状態が悪い"
        ];

        foreach ($conditions as $condition) {
            DB::table('conditions')->insert([
                'condition' => $condition,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
