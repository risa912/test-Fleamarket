@extends('layouts.app')


@section('css')
<link rel="stylesheet" href="{{ asset('css/profile.css') }}">
@endsection


@section('content')
<div class="profile-form">
    <form class="profile-form__form" action="" method="">
        @csrf
        <div class="profile-form__file">
    <div id="image-before" class="profile-form__before"></div>

    <div id="image-preview" class="profile-form__preview">
        @if($user->profile && $user->profile->image)
            <img src="{{ asset('storage/profile_images/' . $user->profile->image) }}" alt="プロフィール画像">
        @endif
    </div>
    <input type="hidden" name="image_preview" id="image_preview_hidden" value="{{ old('image_preview') }}">

    <p class="profile-form__user">
        {{ $user->name }}
    </p>

    <a href="{{ route('profile_edit') }}" class="profile-form__link">
        プロフィールを編集
    </a>
</div>

        <div class="item-group">
            <div class="item-tittle">
                <p class="item-sell" name="item-sell">出品した商品</p>
                <p class="item-buy" name="item-buy">購入した商品</p>
            </div>
            <div class="item-contents">
                <div class="item-content">
                    <a href="" class="item-link"></a>
                    <div class="item-img__before"></div>
                    <img src="asset" alt="商品画像" class="img-content" />
                    <div class="detail-content">
                        <p class="item-name">商品名</p>
                    </div>
                </div>

                <div class="item-content">
                    <a href="" class="item-link"></a>
                    <div class="item-img__before"></div>
                    <img src="asset" alt="商品画像" class="img-content" />
                    <div class="detail-content">
                        <p class="item-name">商品名</p>
                    </div>
                </div>

                <div class="item-content">
                    <a href="" class="item-link"></a>
                    <div class="item-img__before"></div>
                    <img src="asset" alt="商品画像" class="img-content" />
                    <div class="detail-content">
                        <p class="item-name">商品名</p>
                    </div>
                </div>

                <div class="item-content">
                    <a href="" class="item-link"></a>
                    <div class="item-img__before"></div>
                    <img src="asset" alt="商品画像" class="img-content" />
                    <div class="detail-content">
                        <p class="item-name">商品名</p>
                    </div>
                </div>

                <div class="item-content">
                    <a href="" class="item-link"></a>
                    <div class="item-img__before"></div>
                    <img src="asset" alt="商品画像" class="img-content" />
                    <div class="detail-content">
                        <p class="item-name">商品名</p>
                    </div>
                </div>

                <div class="item-content">
                    <a href="" class="item-link"></a>
                    <div class="item-img__before"></div>
                    <img src="asset" alt="商品画像" class="img-content" />
                    <div class="detail-content">
                        <p class="item-name">商品名</p>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
@endsection

@section('scripts')
<script src="{{ asset('js/profileEdit.js') }}"></script>
@endsection