<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\Purchase;
use App\Http\Requests\AddressRequest;
use App\Http\Requests\PurchaseRequest;
use Illuminate\Support\Facades\Auth;
use Stripe\Stripe;
use Stripe\Checkout\Session;

class PurchaseController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | 購入画面
    |--------------------------------------------------------------------------
    */
    public function create($item_id)
    {
        $item = Item::findOrFail($item_id);
        
        if ($item->purchases()->exists()) {
            abort(403, 'この商品はすでに購入されています');
        }

        $profile = Auth::user()->profile;

        $address = session('purchase_address') ?? [
            'postal_code' => $profile->postal_code,
            'address'     => $profile->address,
            'building'    => $profile->building,
        ];

        return view('purchase', compact('item', 'address'));
    }

    /*
    |--------------------------------------------------------------------------
    | 購入確定
    |--------------------------------------------------------------------------
    */
    public function store(PurchaseRequest $request, $item_id)
    {
        $item = Item::findOrFail($item_id);

        if ($item->purchases()->exists()) {
            abort(403, 'この商品はすでに購入されています');
        }

        $request->validate([
            'payment_method' => 'required|in:card,convenience',
        ]);

        $address = session('purchase_address') ?? [
            'postal_code' => Auth::user()->profile->postal_code,
            'address'     => Auth::user()->profile->address,
            'building'    => Auth::user()->profile->building,
        ];

        Purchase::create([
            'item_id'        => $item->id,
            'user_id'        => Auth::id(),
            'image'          => $item->image,
            'postal_code'    => $address['postal_code'],
            'address'        => $address['address'],
            'building'       => $address['building'],
            'payment_method' => $request->payment_method,
        ]);

        session()->forget('purchase_address');

        if ($request->payment_method === 'card') {
            return redirect()->route('stripe.card', $item->id);
        }

        return redirect()->route('stripe.convenience', $item->id);
    }

    /*
    |--------------------------------------------------------------------------
    | カード決済
    |--------------------------------------------------------------------------
    */
    public function stripeCard($item_id)
    {
        $item = Item::findOrFail($item_id);

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

    /*
    |--------------------------------------------------------------------------
    | コンビニ決済
    |--------------------------------------------------------------------------
    */
    public function stripeConvenience($item_id)
    {
        $item = Item::findOrFail($item_id);

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

    /*
    |--------------------------------------------------------------------------
    | 住所変更画面
    |--------------------------------------------------------------------------
    */
    public function editAddress($item_id)
    {
        $item = Item::findOrFail($item_id);
        $profile = Auth::user()->profile;

        return view('address', compact('item', 'profile'));
    }

    /*
    |--------------------------------------------------------------------------
    | 住所更新
    |--------------------------------------------------------------------------
    */
    public function updateAddress(AddressRequest $request, $item_id)
    {
        session([
            'purchase_address' => $request->validated()
        ]);

        return redirect()->route('purchase.create', $item_id);
    }
}
