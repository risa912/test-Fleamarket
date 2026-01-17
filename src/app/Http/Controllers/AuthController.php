<?php

namespace App\Http\Controllers;

use App\Http\Requests\Auth\RegisterRequest;
use App\Http\Requests\Auth\LoginRequest;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;


class AuthController extends Controller
{
    // 会員登録
    public function register(RegisterRequest $request)
    {
        $validated = $request->validated();

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
    ]);


        event(new Registered($user));

        Auth::login($user);

        if (!$user->hasVerifiedEmail()) {
            return redirect()->route('verification.notice'); 
        }

        return redirect()->route('profile.setup'); 
    }

    // ログイン
    public function login(LoginRequest $request)
    {
        $credentials = $request->validated(); 

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            return redirect()->route('mypage');
        }

        return back()->withErrors([
            'email' => 'ログイン情報が登録されていません',
        ])->withInput($request->only('email'));
    }

    // ログアウト
    public function logout()
    {
        Auth::logout();
        return redirect()->route('login.view');
    }
}