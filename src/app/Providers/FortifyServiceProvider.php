<?php

namespace App\Providers;

use App\Models\User;
use App\Actions\Fortify\CreateNewUser;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\ServiceProvider;
use Laravel\Fortify\Fortify;

class FortifyServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // ✅ 会員登録ページ
        Fortify::registerView(function () {
            return view('auth.register');
        });

        // ✅ ログインページ
        Fortify::loginView(function () {
            return view('auth.login');
        });

        // ✅ ユーザー作成時に呼び出すクラスを登録
        Fortify::createUsersUsing(CreateNewUser::class);

        // ✅ ログイン制限
        RateLimiter::for('login', function (Request $request) {
            $email = (string) $request->email;
            return Limit::perMinute(10)->by($email . $request->ip());
        });

        // ✅ ログイン認証処理をカスタマイズ
        Fortify::authenticateUsing(function (Request $request) {
            $user = User::where('email', $request->email)->first();

            if ($user && Hash::check($request->password, $user->password)) {
                return $user;
            }

            session()->flash('login_error', 'ログイン情報が登録されていません');
            return null;
        });
    }
}