<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Http\Requests\AddressRequest;
use Illuminate\Support\Facades\Auth;
use Stripe\Stripe;
use Stripe\Checkout\Session;
use App\Http\Requests\PurchaseRequest;
use App\Models\Purchase;

class PurchaseController extends Controller
{
    // 購入画面
    public function create(Item $item)
    {
        $profile = Auth::user()->profile;
        return view('purchase', compact('item', 'profile'));
    }

    // 購入確定（★ここが唯一の store）
    public function store(PurchaseRequest $request, Item $item)
    {
        $request->validate([
            'payment_method' => 'required|in:card,convenience',
        ]);

        $profile = Auth::user()->profile;

        // ★ 購入情報を保存
        Purchase::create([
            'item_id'     => $item->id,
            'user_id'     => Auth::id(),
            'image'       => $item->image,
            'postal_code' => $profile->postal_code,
            'address'     => $profile->address,
            'building'    => $profile->building,
        ]);

        // ★ 支払い方法で Stripe へ分岐
        if ($request->payment_method === 'card') {
            return redirect()->route('stripe.card', $item->id);
        }

        return redirect()->route('stripe.convenience', $item->id);
    }

    // カード決済
    public function stripeCard(Item $item)
    {
        Stripe::setApiKey(config('services.stripe.secret'));

        $session = Session::create([
            'payment_method_types' => ['card'],
            'line_items' => [[
                'price_data' => [
                    'currency' => 'jpy',
                    'product_data' => [
                        'name' => $item->name,
                    ],
                    'unit_amount' => $item->price,
                ],
                'quantity' => 1,
            ]],
            'mode' => 'payment',
            'success_url' => route('index'),
            'cancel_url' => route('purchase.create', $item->id),
        ]);

        return redirect($session->url);
    }

    // コンビニ決済
    public function stripeConvenience(Item $item)
    {
        Stripe::setApiKey(config('services.stripe.secret'));

        $session = Session::create([
            'payment_method_types' => ['konbini'],
            'line_items' => [[
                'price_data' => [
                    'currency' => 'jpy',
                    'product_data' => [
                        'name' => $item->name,
                    ],
                    'unit_amount' => $item->price,
                ],
                'quantity' => 1,
            ]],
            'mode' => 'payment',
            'success_url' => route('index'),
            'cancel_url' => route('purchase.create', $item->id),
        ]);

        return redirect($session->url);
    }

    // 住所変更画面
    public function editAddress(Item $item)
    {
        $profile = Auth::user()->profile;
        return view('address', compact('item', 'profile'));
    }

    // 住所更新
    public function updateAddress(AddressRequest $request, Item $item)
    {
        $validated = $request->validated();

        Auth::user()->profile->update($validated);

        return redirect()->route('purchase.create', $item->id);
    }
}