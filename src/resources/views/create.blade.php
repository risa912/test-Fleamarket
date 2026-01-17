@extends('layouts.app')


@section('css')
<link rel="stylesheet" href="{{ asset('css/create.css') }}">
@endsection


@section('content')
<div class="create-form">
    <h2 class="create-form__heading content__heading">商品の出品</h2>
    <div class="create-form__inner">
       <form class="create-form__form" action="{{ route('items.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="create-form__group">
                <label class="create-form__image-label" for="image">商品画像</label>
                <div class="create-form__file">
                    <div id="create-form__before" class="create-form__before"></div>
                    <label class="create-form__file-label" for="image">画像を選択する</label>
                    <input class="create-form__image-input" type="file" name="image" id="image" accept="image/*">
                </div>
                <p class="create-form__error-message">
                    @error('image')
                        {{ $message }}
                    @enderror
                </p>
            </div>

            <div class="create-form__category">
                <div class="create-form__box">
                    <h3 class="create-form__tittle">商品の詳細</h3>
                </div>
                <div class="create-form__group">
                    <label class="create-form__category-label">カテゴリー</label>
                    <div class="contact-form__category-inputs">
                        @foreach($categories as $category)
                            <input type="checkbox" name="categories[]" id="category-{{ $category->id }}" value="{{ $category->id }}" class="create-form__category-input" hidden
                                {{ in_array($category->id, old('categories', [])) ? 'checked' : '' }}>
                            <label for="category-{{ $category->id }}" class="category">
                                {{ $category->name }}
                            </label>
                        @endforeach
                    </div>
                    <p class="create-form__error-message">
                        @error('categories')
                            {{ $message }}
                        @enderror
                    </p>
                </div>
            </div>

            <div class="create-form__group">
                <label class="create-form__label" for="condition_id">商品の状態</label>
                <div class="create-form__select-inner">
                    <select class="create-form__select" name="condition_id" id="condition_id">
                        <option disabled selected>選択してください</option>
                        @foreach($conditions as $condition)
                            <option class="create-form__option" value="{{ $condition->id }}" {{ old('condition_id') == $condition->id ? 'selected' : '' }}>
                                {{ $condition->condition }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <p class="create-form__error-message">
                    @error('condition_id')
                        {{ $message }}
                    @enderror
                </p>
            </div>

            <div class="create-form__name">
                <div class="create-form__box">
                    <h3 class="create-form__tittle">商品名と説明</h3>
                </div>
                <div class="create-form__group">
                    <label class="create-form__name-label" for="name">商品名</label>
                    <input class="create-form__name-input" type="text" name="name" id="name" value="{{ old('name') }}">
                    <p class="create-form__error-message">
                        @error('name')
                            {{ $message }}
                        @enderror
                    </p>
                </div>
            </div>

            <div class="create-form__group">
                <label class="create-form__label" for="brand">ブランド名</label>
                <input class="create-form__input" type="text" name="brand" id="brand" value="{{ old('brand') }}">
            </div>

            <div class="create-form__group">
                <label class="create-form__label" for="description">商品の説明</label>
                <textarea class="create-form__textarea" name="description" id="description" cols="30" rows="10">{{ old('description') }}</textarea>
                <p class="create-form__error-message">
                    @error('description')
                        {{ $message }}
                    @enderror
                </p>
            </div>

            <div class="create-form__group">
                <label class="create-form__label" for="price">販売価格</label>

                <div class="create-form__wrapper">
                    <span class="create-form__symbol">¥</span>
                    <input class="create-form__input create-form__input--price" type="text" name="price" id="price" value="{{ old('price') }}">
                </div>
                <p class="create-form__error-message">
                    @error('price')
                        {{ $message }}
                    @enderror
                </p>
            </div>

            <div class="create-form__btn-inner">
                <input class="create-form__btn btn" type="submit" value="出品する">
            </div>
        </form>
    </div>
</div>

<script>
document.getElementById('image').addEventListener('change', function(e) {
    const preview = document.getElementById('create-form__before'); 
    const label = document.querySelector('.create-form__file-label');
    preview.innerHTML = '';

    const file = e.target.files[0];
    if (!file) return;

    const img = document.createElement('img');
    img.src = URL.createObjectURL(file);
    img.style.maxWidth = '200px';
    img.style.borderRadius = '8px';

    preview.appendChild(img);

    label.classList.add('small');
});
</script>
@endsection