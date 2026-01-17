<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\ProfileRequest;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{

     public function index()
    {
        $user = Auth::user()->load('profile');
        return view('profile', compact('user'));
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