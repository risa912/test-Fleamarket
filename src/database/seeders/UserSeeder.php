<?php


namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('users')->insert([
            [
                'name' => 'かな',
                'email' => 'kana@example.com',
                'password' => Hash::make('kana1234')
            ],
            [
                'name' => 'タロウ',
                'email' => 'taro@yamada.com',
                'password' => Hash::make('taro8910')
            ],
            [
                'name' => 'miyu',
                'email' => 'miyu@yoshino.com',
                'password' => Hash::make('miyu4567')
            ],
            [
                'name' => 'ことり',
                'email' => 'kotori@dd.jp',
                'password' => Hash::make('kotori123')
            ],
            [
                'name' => 'ai',
                'email' => 'ai@momose.com',
                'password' => Hash::make('ai45678')
            ],
        ]);
    }
}
