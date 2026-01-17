<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ItemLike; 
use App\Models\User;
use App\Models\Item;

class ItemLikeSeeder extends Seeder
{
    public function run(): void
    {
        $users = User::all();
        $items = Item::all();

        if ($users->count() === 0 || $items->count() === 0) {
            return;
        }

        foreach ($users as $user) {
            $likeItems = $items->random(rand(3, 8));

            foreach ($likeItems as $item) {
                ItemLike::firstOrCreate([
                    'user_id' => $user->id,
                    'item_id' => $item->id,
                ]);
            }
        }
    }
}
