@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/show.css') }}">
@endsection

@section('content')
<div class="show">
    <div class="image-box">
        @if($item->purchases->count() > 0)
            <span class="sold-label">Sold</span>
        @endif
        <img src="{{ asset('storage/' . $item->image) }}"
            alt="商品画像"
            class="show-img">
    </div>
        <div class="show-info">
            <h1 class="product-name">{{ $item->name }}</h1>
            <p class="brand">{{ $item->brand }}</p>
            <p class="price">
                ¥{{ number_format($item->price) }} <span class="price-tax">（税込）</span>
            </p>
            
            <div class="reaction">
                <div class="reaction-item">
                    <form action="{{ route('items.like', $item->id) }}" method="post" class="like-form">
                        @csrf
                        <button type="submit" class="like-button">
                            <img class="like__img" src="{{ $hasLiked ? asset('images/Vector.png') : asset('images/icon_heart.png') }}" alt="いいね">
                            <span class="reaction-count">{{ $item->likes->count() }}</span>
                        </button>
                    </form>
                </div>
                <form action="{{ route('items.comment', $item->id) }}" method="post">
                    @csrf
                    <div class="reaction-item">
                    <img class="comment__img" src="{{ asset('images/icon_comment_.svg') }}" alt="コメント">
                    <span class="reaction-count reaction-count--comment">
                        {{ $item->comments->count() }}
                    </span>
                </div>
                </form>
            </div>

            @if ($isPurchased)
                {{-- 購入済み --}}
                <button class="show-form__btn show-form__btn--disabled" disabled>
                    購入済み
                </button>

            @elseif ($isOwner)
                {{-- 自分の出品 --}}
                <button class="show-form__btn show-form__btn--disabled" disabled>
                    購入不可
                </button>

            @else
                {{-- 購入可能 --}}
                <button class="show-form__btn show-form__btn--purchase">
                    <a class="show-link" href="{{ route('purchase.create', $item->id) }}">
                        購入手続きへ
                    </a>
                </button>
            @endif

            <section class="section">
                <h2 class="section-tittle">商品説明</h2>
                <p class="text">{{ $item->description }}</p>
            </section>

            <section class="section">
                <h2 class="section-tittle">商品の情報</h2>
                <div class="genle-box">
                    <p class="genle">
                    カテゴリー
                    @foreach ($item->categories as $category)
                        <span class="category-tag">{{ $category->name }}</span>
                    @endforeach
                </p>

                <p class="genle">
                    商品の状態
                    <span class="condition">{{ $item->condition->condition }}</span>
                </p>
            </section>

            <section class="section">
                <h2 class="section-tittle section-tittle--comment">
                コメント（{{ $item->comments->count() }}）
                </h2>

                @foreach ($item->comments as $comment)
                    <div class="comment">
                        <div class="comment-body">
                            <div class="user-icon">
                                 <img src="{{ optional($comment->user->profile)->image? asset('storage/profile_images/' . $comment->user->profile->image): asset('images/default-user.png') }}"alt="ユーザー画像" class="img-content"/>
                            </div>
                            <p class="user-name">{{ $comment->user->name }}</p>
                        </div>
                        <p class="comment-text">{{ $comment->comment }}</p>
                    </div>
                @endforeach
            </section>

            <section class="section section--another">
                <h2 class="section-tittle section-tittle--another">商品へのコメント</h2>
               <form action="{{ route('items.comment', $item->id) }}" method="post">
                    @csrf
                    <div class="show-form__group">
                        <textarea class="show-form__textarea" name="comment" cols="30"
                            rows="5">
                        </textarea>
                        <p class="show-form__error-message">
                            @error('comment')
                                {{ $message }}
                            @enderror
                        </p>
                    </div>
                    <div class="show-form__btn-inner">
                        <button class="show-form__btn btn" type="submit">コメントを送信する</button>
                    </div>
                </form>
            </section>
        </div>
    </div>
</div>
@endsection