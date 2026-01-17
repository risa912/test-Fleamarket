<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Profile;
use App\Models\User;
use Faker\Factory;

class ProfileSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = \Faker\Factory::create('ja_JP');

        $users = User::all();

        $images = [
            'apple.jpg',
            '26927025.png',
            '33682324_s.jpg',
            '33491552_s.jpg',
            '106.png',
            '23.png',
            '26902770.png',
            'halloween_color.png',
            '27042849.png',
            'cherry.jpg',
            '33959234_s.jpg',
        ];

        foreach ($users as $user) {
            Profile::create([
                'user_id' => $user->id,
                'name' => $faker->name(), 
                'image' => $images[array_rand($images)], 
                'postal_code' => $faker->numerify('###-####'),
                'address' => $faker->prefecture() . $faker->city() . $faker->streetAddress(),
                'building' => $faker->optional()->secondaryAddress(),
            ]);
        }
    }
}