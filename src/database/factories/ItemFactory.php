<?php

namespace Database\Factories;

use App\Models\Item;
use App\Models\User;
use App\Models\Condition;
use Illuminate\Database\Eloquent\Factories\Factory;

class ItemFactory extends Factory
{
    protected $model = Item::class;

    public function definition()
    {
        return [
            'name' => $this->faker->word(),
            'brand' => $this->faker->company(),
            'description' => $this->faker->sentence(),
            'price' => $this->faker->numberBetween(1000, 100000),
            'condition_id' => Condition::factory(), // Condition も factory が必要
            'image' => 'sample.jpg', // ダミー画像名
            'user_id' => User::factory(), // テスト用にユーザー作成
        ];
    }
}
