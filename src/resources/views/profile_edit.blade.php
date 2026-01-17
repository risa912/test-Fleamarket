@extends('layouts.app')


@section('css')
<link rel="stylesheet" href="{{ asset('css/profileEdit.css') }}">
@endsection


@section('content')
    <div class="profileEdit-form">
        <h2 class="profileEdit-form__heading content__heading">プロフィール設定</h2>
        <div class="profileEdit-form__inner">
            <form class="profileEdit-form__form" action="{{ route('profile_update') }}" 
                method="POST" enctype="multipart/form-data">
                @csrf
                <div class="profileEdit-form__group">
                    <div class="profileEdit-form__file">
                        <div id="image-before" class="profileEdit-form__before"></div>
                        <div id="image-preview" class="profileEdit-form__preview">
                            @if($user->profile && $user->profile->image)
                                <img src="{{ asset('storage/profile_images/' . $user->profile->image) }}" alt="プロフィール画像">
                            @endif
                        </div>

                        <input type="hidden" name="image_preview" id="image_preview_hidden" value="{{ old('image_preview') }}">
                        <label class="profileEdit-form__file-label" for="image">画像を選択する</label>
                        <input class="profileEdit-form__image-input" type="file" name="image" id="image" accept="image/*">
                    </div>
                    <p class="profileEdit-form__error-message">
                        @error('image')
                            {{ $message }}
                        @enderror
                    </p>
                </div>

                <div class="profileEdit-form__group">
                    <label class="profileEdit-form__label" for="name">ユーザー名</label>
                    <input class="profileEdit-form__input" type="text" name="name" id="name"  value="{{ old('name', $user->name) }}">
                    <p class="profileEdit-form__error-message">
                        @error('name')
                            {{ $message }}
                        @enderror
                    </p>
                </div>

                <div class="profileEdit-form__group">
                    <label class="profileEdit-form__label" for="postal_code">郵便番号</label>
                    <input class="profileEdit-form__input" type="text" name="postal_code" value="{{ old('postal_code', $user->profile->postal_code ?? '') }}">
                    <p class="profileEdit-form__error-message">
                        @error('postal_code')
                            {{ $message }}
                        @enderror
                    </p>
                </div>

                <div class="profileEdit-form__group">
                    <label class="profileEdit-form__label" for="address">住所</label>
                    <input class="profileEdit-form__input" type="text" name="address" value="{{ old('address', $user->profile->address ?? '') }}">
                    <p class="profileEdit-form__error-message">
                        @error('address')
                            {{ $message }}
                        @enderror
                    </p>
                </div>

                <div class="profileEdit-form__group">
                    <label class="profileEdit-form__label" for="building">建物名</label>
                    <input class="profileEdit-form__input" type="text" name="building" value="{{ old('building', $user->profile->building ?? '') }}">
                    <p class="profileEdit-form__error-message">
                        @error('building')
                            {{ $message }}
                        @enderror
                    </p>
                </div>

                <div class="profileEdit-form__btn-inner">
                    <button class="profileEdit-form__btn btn" type="submit">更新する</button>
                </div>
            </form>
        </div>
    </div>
@endsection

@section('scripts')
<script src="{{ asset('js/profileEdit.js') }}"></script>
@endsection