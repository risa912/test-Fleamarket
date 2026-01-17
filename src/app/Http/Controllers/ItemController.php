<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request; 
use App\Http\Requests\CommentRequest;
use App\Models\Item;         

class ItemController extends Controller
{
    public function __construct()
    {
        // マイリスト・いいねは認証必須
        $this->middleware('auth')->only(['indexMylist', 'update']);
    }

    // 商品一覧（おすすめ）
    public function index(Request $request)
    {
        $tab = $request->get('tab', 'all');

        if ($tab === 'mylist') {
            // ★ 設計書どおり indexMylist に処理委譲
            return $this->indexMylist();
        }

        $items = Item::with(['condition', 'categories'])->get();
        $tab = 'all';

        return view('index', compact('items', 'tab'));
    }

    // 商品一覧（マイリスト）※ 設計書で「必要」
    public function indexMylist()
    {
        // 未ログイン or 未認証 → 何も表示しない
        if (!auth()->check() || !auth()->user()->hasVerifiedEmail()) {
            $items = collect();
        } else {
            $items = auth()->user()
                ->likedItems()
                ->with(['condition', 'categories'])
                ->get();
        }

        $tab = 'mylist';

        return view('index', compact('items', 'tab'));
    }

    // 商品詳細
    public function show(Item $item)
    {
        $item->load([
            'condition',
            'categories',
            'comments.user.profile',
            'likes',
        ]);

        return view('show', compact('item'));
    }

    // いいね・コメント（認証必須）

    public function update(CommentRequest $request, Item $item)
    {
        $user = auth()->user();

        if ($request->filled('comment')) {
            $item->comments()->create([
                'user_id' => $user->id,
                'comment' => $request->comment,
            ]);
        }

        if ($request->has('like')) {
            $like = $item->likes()->where('user_id', $user->id)->first();

            if ($like) {
                $like->delete();
            } else {
                $item->likes()->create(['user_id' => $user->id]);
            }
        }

        return redirect()->route('items.show', $item);
    }
}