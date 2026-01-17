@extends('layouts.app')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/auth/certification.css')}}">
@endsection

@section('content')
<div class="certification-form">
    <div class="certification-form__inner">
        <p class="certification-form__text">
            登録していただいたメールアドレスに認証メールを送付しました。<br>
            メール認証を完了してください。
        </p>
        <form class="certification-form__send"> 
            @csrf
            <div class="certification-form__btn-inner"> 
                <a href="http://localhost:8025/" class="certification-form__btn btn"> 認証はこちらから </a> 
            </div> 
        </form>

        <form class="certification-form__send" action="{{ route('verification.send') }}" method="POST">
            @csrf
            <button class="certification-form__next-btn" type="submit">認証メールを再送する</button>
        </form>
    </div>
</div>
@endsection('content')