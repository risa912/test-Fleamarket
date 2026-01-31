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
        $keyword = $request->get('keyword');

        if ($tab === 'mylist') {
            return $this->indexMylist($request);
        }

        $items = Item::with(['condition', 'categories'])
            // 自分の商品を除外
            ->when(auth()->check(), function ($query) {
                $query->where(function ($q) {
                    $q->where('user_id', '!=', auth()->id())
                    ->orWhereNull('user_id');
                });
            })
            // 🔍 商品名の部分一致検索
            ->when($keyword, function ($query) use ($keyword) {
                $query->where('name', 'like', '%' . $keyword . '%');
            })
            ->get();

        return view('index', compact('items', 'tab'));
    }

    // 商品一覧（マイリスト）※ 設計書で「必要」
    public function indexMylist(Request $request)
    {
        $keyword = $request->get('keyword');

        if (!auth()->check() || !auth()->user()->hasVerifiedEmail()) {
            $items = collect();
        } else {
            $items = auth()->user()
                ->likedItems()
                ->with(['condition', 'categories'])
                ->when($keyword, function ($query) use ($keyword) {
                    $query->where('name', 'like', '%' . $keyword . '%');
                })
                ->get();
        }

        $tab = 'mylist';

        return view('index', compact('items', 'tab'));
    }

    // 商品詳細
    public function show($item_id)
    {
        $item = Item::findOrFail($item_id);

        $item->load([
            'condition',
            'categories',
            'comments.user.profile',
            'likes',
            'purchases',
        ]);

        $hasLiked = false;
        if (auth()->check()) {
            $hasLiked = $item->likes()
                ->where('user_id', auth()->id())
                ->exists();
        }

        $isPurchased = $item->purchases()->exists();

        // ★ 自分の出品か？
        $isOwner = auth()->check() && $item->user_id === auth()->id();

        return view('show', compact(
            'item',
            'hasLiked',
            'isPurchased',
            'isOwner'
        ));
    }


    // いいね（認証必須）
    public function toggleLike($item_id)
    {
        $item = Item::findOrFail($item_id);
        $user = auth()->user();

        $like = $item->likes()
            ->where('user_id', $user->id)
            ->first();

        if ($like) {
            $like->delete();
        } else {
            $item->likes()->create([
                'user_id' => $user->id
            ]);
        }

        return back();
    }

    // コメント（認証必須）
    public function storeComment(CommentRequest $request, $item_id)
    {
        $item = Item::findOrFail($item_id);

        $item->comments()->create([
            'user_id' => auth()->id(),
            'comment' => $request->comment,
        ]);

        return back();
    }
}