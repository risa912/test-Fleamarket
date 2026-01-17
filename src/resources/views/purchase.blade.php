@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/purchase.css') }}">
@endsection

@section('content')
<div class="purchase">
    <form class="purchase-form" action="{{ route('purchase.store', $item->id) }}" method="POST">
    @csrf
        <div class="purchase-left">
            <div class="purchase-item">
                <div class="image-box">
                   <img src="{{ asset('storage/' . $item->image) }}" alt="商品画像"class="purchase-img">
                </div>
                <div class="purchase-item__info">
                     <p class="product-name">{{ $item->name }}</p>
                    <p class="price">¥{{ number_format($item->price) }}</p>
                </div>
            </div>


            <section class="purchase-box">
                <h3 class="purchase-box__tittle">支払い方法</h3>
                <div class="purchase-box__inner">
                    <select class="select-box" id="payment_method" name="payment_method">
                        <option value="">選択してください</option>
                        <option value="convenience" {{ old('payment_method') === 'convenience' ? 'selected' : '' }}>
                            コンビニ払い
                        </option>
                        <option value="card" {{ old('payment_method') === 'card' ? 'selected' : '' }}>
                            カード支払い
                        </option>
                    </select>
                </div>
                <p class="payment__error-message">
                    @error('payment_method')
                        {{ $message }}
                    @enderror
                </p>
            </section>

            <section class="purchase-box">
                <h3 class="purchase-box__tittle">配送先
                    <a class="purchase-link" href="{{ route('address.edit', $item->id) }}">
                        変更する
                    </a>
                </h3>

                @if($profile)
                    <p class="postal-code">
                        〒 {{ $profile->postal_code }}
                    </p>
                    <p class="address-text">
                        {{ $profile->address }}
                        {{ $profile->building }}
                    </p>
                @else
                    <p class="postal-code">〒 未登録</p>
                    <p class="address-text">住所未登録</p>
                @endif
            </section>
            <p class="purchase__error-message">
                @error('address')
                    {{ $message }}
                @enderror
            </p>
        </div>

        <div class="purchase-right">
            <div class="summary">
                <p class="summary__item">商品代金 
                    <span class="summary__price">¥{{ number_format($item->price) }}</span>
                </p>
                <p class="summary__payment">支払い方法 
                    <span class="summary__method" id="payment-text">未選択</span>
                </p>
            </div>

            <div class="purchase-form__btn-inner">     
                <button class="purchase-form__btn btn" type="submit">購入する</button>
            </div>
        </div>
    </form>
</div>
@endsection

<script>
document.addEventListener('DOMContentLoaded', function () {
    const select = document.getElementById('payment_method');
    const paymentText = document.getElementById('payment-text');

    select.addEventListener('change', function () {
        if (this.value === '') {
            paymentText.textContent = '未選択';
        } else {
            paymentText.textContent =
                this.options[this.selectedIndex].text;
        }
    });
});
</script>