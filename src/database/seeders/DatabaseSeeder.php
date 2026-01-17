<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
    $this->call([
        CategorySeeder::class,
        ConditionSeeder::class,
        UserSeeder::class,         
        ProfileSeeder::class,      
        ItemSeeder::class,         
        CommentSeeder::class,      
        ItemCategorySeeder::class,
        ItemLikeSeeder::class,
        PurchaseSeeder::class, 
    ]);
    }

}
