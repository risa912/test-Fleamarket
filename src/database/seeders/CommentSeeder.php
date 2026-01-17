<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Comment;
use App\Models\User;
use App\Models\Item;

class CommentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = User::all();
        $items = Item::all();

        $commentTemplates = [
            '購入を検討しています。',
            '値下げは可能でしょうか？',
            '配送方法は何になりますか？',
            '迅速な対応ありがとうございます！',
            'もう少し詳しい説明をお願いできますか？',
            'とても気に入りました！',
            '検討中です、もう少し時間をください。',
            '色やサイズ感は写真と同じでしょうか？'
        ];

        foreach ($users as $user) {
            // 0〜5件のコメント
            $numberOfComments = rand(0, 5);
            if ($numberOfComments === 0 || $items->count() === 0) continue;

            // itemsの数が少ない場合はminで調整
            $commentedItems = $items->random(min($numberOfComments, $items->count()));

            foreach ($commentedItems as $item) {
                Comment::create([
                    'user_id' => $user->id,
                    'item_id' => $item->id,
                    'comment' => $commentTemplates[array_rand($commentTemplates)],
                ]);
            }
        }
    }
}
