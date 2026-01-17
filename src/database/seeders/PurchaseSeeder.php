<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Purchase;
use App\Models\User;
use App\Models\Item;

class PurchaseSeeder extends Seeder
{
    public function run(): void
    {
        $users = User::with('profile')->get();
        $items = Item::all();

        $paymentMethods = ['convenience', 'card'];

        foreach ($users as $user) {
            // プロフィールがないユーザーはスキップ
            if (!$user->profile) {
                continue;
            }

            $numberOfPurchases = rand(0, 3);
            if ($numberOfPurchases === 0) {
                continue;
            }

            $purchasedItems = $items->random($numberOfPurchases);

            foreach ($purchasedItems as $item) {
                Purchase::create([
                    'user_id' => $user->id,
                    'item_id' => $item->id,
                    'payment_method' => $paymentMethods[array_rand($paymentMethods)],
                    'postal_code' => $user->profile->postal_code,
                    'address' => $user->profile->address,
                    'building' => $user->profile->building,
                ]);
            }
        }
    }
}
