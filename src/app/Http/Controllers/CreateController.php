<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\ExhibitionRequest;
use App\Models\Category;
use App\Models\Condition;
use App\Models\Item;

class CreateController extends Controller
{
    // 出品画面表示
    public function create()
    {
        $categories = Category::all();
        $conditions = Condition::all();
        return view('create', compact('categories', 'conditions'));
    }

    // 出品処理
    public function store(ExhibitionRequest $request)
    {
        $data = $request->validated();

        $path = $request->file('image')->store('items', 'public');
        $data['image'] = $path;

        // 任意項目
        $data['brand'] = $request->brand ?? '';
        $data['user_id'] = auth()->id();

        $item = Item::create($data);

        // カテゴリー同期
        if ($request->categories) {
            $item->categories()->sync($request->categories);
        }

        return redirect()->route('mypage')->with('message', '商品を出品しました！');
    }
}