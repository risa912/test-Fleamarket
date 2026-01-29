<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\ProfileRequest;
use Illuminate\Support\Facades\Auth;
use App\Models\Item;

class ProfileController extends Controller
{

    public function index(Request $request)
    {
        $user = Auth::user()->load('profile');

        $page = $request->query('page', 'sell'); // デフォルトは sell

        if ($page === 'buy') {
            // 購入した商品一覧
            $items = Item::whereHas('purchases', function ($q) use ($user) {
                $q->where('user_id', $user->id);
            })->get();
        } else {
            // 出品した商品一覧
            $items = Item::where('user_id', $user->id)->get();
        }

        return view('profile', compact('user', 'items', 'page'));
    }
    
    public function edit()
    {

        $user = Auth::user()->load('profile');
        return view('profile_edit', compact('user'));
    }

    public function update(ProfileRequest $request)
    {
        $user = Auth::user();
        $profile = $user->profile;

        $data = $request->validated();

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('public/profile_images');
            $data['image'] = basename($path); 
        } elseif ($profile) {
            $data['image'] = $profile->image;
        } else {
            $data['image'] = 'default.png';
        }

        $user->profile()->updateOrCreate(
            ['user_id' => $user->id],
            $data
        );

        return redirect()->route('mypage')->with('success', 'プロフィールを更新しました。');
    }

}