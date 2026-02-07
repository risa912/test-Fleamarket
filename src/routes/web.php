<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\EmailVerificationRequest;

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CreateController;
use App\Http\Controllers\PurchaseController;

/*
|--------------------------------------------------------------------------
| 商品一覧
|--------------------------------------------------------------------------
*/
Route::get('/', [ItemController::class, 'index'])->name('index');
Route::middleware(['auth'])->group(function () {
    // ログインユーザーのマイリスト
    Route::get('/mylist', [ItemController::class, 'myList'])
        ->name('mylist.index');
});

/*
|--------------------------------------------------------------------------
| 認証（登録・ログイン）
|--------------------------------------------------------------------------
*/
Route::get('/register', function () {
    return view('auth.register');
})->name('register.view');

Route::post('/register', [AuthController::class, 'register'])->name('register');

Route::get('/login', function () {
    return view('auth.login');
})->name('login.view');

Route::post('/login', [AuthController::class, 'login'])->name('login');
Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth')->name('logout');

/*
|--------------------------------------------------------------------------
| メール認証
|--------------------------------------------------------------------------
*/
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

/*
|--------------------------------------------------------------------------
| 商品詳細・リアクション
|--------------------------------------------------------------------------
*/
Route::get('/item/{item_id}', [ItemController::class, 'show'])
    ->name('items.show');

Route::post('/items/{item_id}/comment', [ItemController::class, 'storeComment'])
    ->middleware('auth')
    ->name('items.comment');

Route::post('/items/{item_id}/like', [ItemController::class, 'toggleLike'])
    ->middleware('auth')
    ->name('items.like');

/*
|--------------------------------------------------------------------------
| 認証必須エリア
|--------------------------------------------------------------------------
*/
Route::middleware(['auth'])->group(function () {

    /*
    | プロフィール
    */
    Route::get('/mypage', [ProfileController::class, 'index'])
        ->middleware('verified')
        ->name('mypage');

    Route::get('/mypage/profile', [ProfileController::class, 'edit'])
        ->middleware('verified')
        ->name('profile_edit');

    Route::post('/mypage/profile', [ProfileController::class, 'update'])
        ->middleware('verified')
        ->name('profile_update');

    /*
    | 商品出品
    */
    Route::get('/sell', [CreateController::class, 'create'])->name('sell');
    Route::post('/sell', [CreateController::class, 'store'])->name('items.store');

    /*
    | 商品購入
    */
    Route::get('/purchase/{item_id}', [PurchaseController::class, 'create'])
        ->name('purchase.create');

    Route::post('/purchase/{item_id}', [PurchaseController::class, 'store'])
        ->name('purchase.store');

    Route::get('/purchase/address/{item_id}', [PurchaseController::class, 'editAddress'])
        ->name('address.edit');

    Route::post('/purchase/address/{item_id}', [PurchaseController::class, 'updateAddress'])
        ->name('address.update');

    /*
    | Stripe
    */
    Route::get('/stripe/card/{item}', [PurchaseController::class, 'stripeCard'])
        ->name('stripe.card');

    Route::get('/stripe/convenience/{item}', [PurchaseController::class, 'stripeConvenience'])
        ->name('stripe.convenience');
});