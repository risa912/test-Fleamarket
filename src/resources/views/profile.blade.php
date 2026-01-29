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
                <a href="{{ route('mypage', ['page' => 'sell']) }}" class="tab-link {{ $page === 'sell' ? 'active' : '' }}">
                出品した商品
                </a>

                <a href="{{ route('mypage', ['page' => 'buy']) }}" class="tab-link {{ $page === 'buy' ? 'active' : '' }}">
                購入した商品
                </a>
            </div>
            <div class="item-contents">
                @foreach($items as $item)
                    <div class="item-content">
                        <a href="{{ route('items.show', $item) }}" class="item-link">
                            @if($item->purchases->count() > 0)
                                <span class="sold-label">Sold</span>
                            @endif

                            <img src="{{ asset('storage/' . $item->image) }}"
                                alt="商品画像"
                                class="img-content" />

                            <div class="detail-content">
                                <p class="item-name">{{ $item->name }}</p>
                            </div>
                        </a>
                    </div>
                @endforeach
            </div>
        </div>
    </form>
</div>
@endsection

@section('scripts')
<script src="{{ asset('js/profileEdit.js') }}"></script>
@endsection