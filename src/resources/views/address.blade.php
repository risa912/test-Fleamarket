@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/address.css') }}">
@endsection

@section('content')
<div class="address-form">
    <h2 class="address-form__heading content__heading">住所の変更</h2>
    <div class="address-form__inner">
        <form action="{{ route('address.update', $item->id) }}" class="address-form__form" method="POST">
            @csrf
            <div class="address-form__group">
                <label class="address-form__label" for="postal_code">郵便番号</label>
                <input class="address-form__input" type="text" name="postal_code" value="{{ old('postal_code', $item->address->postal_code ?? '') }}">
                <p class="address-form__error-message">
                    @error('postal_code')
                        {{ $message }}
                    @enderror
                </p>
            </div>

            <div class="address-form__group">
                <label class="address-form__label" for="address">住所</label>
                <input class="address-form__input" type="text" name="address" value="{{ old('address', $item->address->address ?? '') }}">
                <p class="address-form__error-message">
                    @error('address')
                         {{ $message }}
                    @enderror
                </p>
            </div>

            <div class="address-form__group">
                <label class="address-form__label" for="building">建物名</label>
                <input class="address-form__input" type="text" name="building" value="{{ old('building', $item->address->building ?? '') }}">
            </div>

            <div class="address-form__btn-inner">
                <button class="address-form__btn btn" type="submit">更新する</button>
            </div>
        </form>
    </div>
</div>
@endsection