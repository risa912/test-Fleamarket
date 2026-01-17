<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CommonController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CreateController; 
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use App\Http\Controllers\PurchaseController;
use Illuminate\Http\Request;

// 全商品一覧・マイリスト
Route::get('/', [ItemController::class, 'index'])->name('index');
Route::get('/mylist', [ItemController::class, 'indexMylist'])->name('index.mylist');


Route::get('/search', [CommonController::class, 'search'])->name('search');

// 登録画面
Route::get('/register', function () {
    return view('auth.register');
})->name('register.view');

Route::post('/register', [AuthController::class, 'register'])->name('register');
Route::get('/login', function () {
    return view('auth.login');
})->name('login.view');

// ログイン・ログアウト処理
Route::post('/login', [AuthController::class, 'login'])->name('login');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// メール認証処理
Route::get('/email/verify', function () {
    return view('auth.certification'); 
})->middleware('auth')->name('verification.notice');

Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
    $request->fulfill();  
    return redirect()->route('profile_edit');
})->middleware(['auth', 'signed'])->name('verification.verify');

Route::post('/email/verification-notification', function (Request $request) {
    $request->user()->sendEmailVerificationNotification();
    return back()->with('message', '認証メールを再送信しました。');
})->middleware(['auth', 'throttle:6,1'])->name('verification.send');


// マイページ
Route::get('/mypage', [ProfileController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('mypage');

Route::get('/mypage/profile', [ProfileController::class, 'edit'])
    ->middleware(['auth', 'verified'])
    ->name('profile_edit');

Route::post('/mypage/profile', [ProfileController::class, 'update'])
    ->middleware(['auth', 'verified'])
    ->name('profile_update');


// 出品画面
Route::middleware(['auth'])->group(function () {
    Route::get('/sell', [CreateController::class, 'create'])
        ->name('sell');

    Route::post('/sell', [CreateController::class, 'store'])
        ->name('items.store');
});

// 商品詳細ページ
Route::get('/items/{item}', [ItemController::class, 'show'])->name('items.show');
// コメント・いいね
Route::post('/items/{item}', [ItemController::class, 'update'])->name('items.update');


Route::middleware('auth')->group(function () {

    // 商品購入画面
    Route::get('/purchase/{item}', [PurchaseController::class, 'create'])
        ->name('purchase.create');

    // 購入処理
    Route::post('/purchase/{item}', [PurchaseController::class, 'store'])
        ->name('purchase.store');

    // 配送先編集
    Route::get('/purchase/address/{item}', [PurchaseController::class, 'editAddress'])
        ->name('address.edit');

    // 配送先更新（保存）
    Route::post('/purchase/address/{item}', [PurchaseController::class, 'updateAddress'])
        ->name('address.update');

    // Stripe 決済
    Route::get('/stripe/card/{item}', [PurchaseController::class, 'stripeCard'])
        ->name('stripe.card');

    Route::get('/stripe/convenience/{item}', [PurchaseController::class, 'stripeConvenience'])
        ->name('stripe.convenience');
});