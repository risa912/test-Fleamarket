@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/auth/login.css')}}">
@endsection

@section('content')
<div class="login-form">
    <h2 class="login-form__heading content__heading">ログイン</h2>
    <div class="login-form__inner">
        <form class="login-form__form" action="{{ route('login') }}" method="POST">
            @csrf
            <div class="login-form__group">
                <label class="login-form__label" for="email">メールアドレス</label>
                <input class="login-form__input" type="mail" name="email" id="email" value="{{ old('email') }}">
                @error('email')
                    <p class="login-form__error-message">
                        {{ $message }}
                    </p>
                @enderror
            </div>

            <div class="login-form__group">
                <label class="login-form__label" for="password">パスワード</label>
                <input class="login-form__input" type="password" name="password" id="password">
                @error('password')
                    <p class="login-form__error-message">
                        {{ $message }}
                    </p>
                @enderror
            </div>

            <div class="login-form__btn-inner">
                <button class="login-form__btn btn" type="submit">ログインする</button>
                <a class="login-form__next-btn" href="{{ route('register') }}">会員登録はこちら</a>
            </div>
        </form>
    </div>
</div>
@endsection