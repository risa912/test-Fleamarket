@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/index.css') }}">
@endsection

@section('content')
<div class="top-form">
    <form class="top-form__form" action=""  method="">
        @csrf
        <div class="top-group">
            <div class="top-title">
                <a href="{{ url('/?tab=all') }}"
                class="top-tab {{ $tab === 'all' ? 'active' : '' }}">
                    おすすめ
                </a>

                <a href="{{ url('/?tab=mylist') }}"
                class="top-tab {{ $tab === 'mylist' ? 'active' : '' }}">
                    マイリスト
                </a>
            </div>

            <div class="top-contents">
                @foreach ($items as $item)
                <a href="{{ route('items.show', $item) }}" class="top-link">
                    <div class="top-content">
                        <div class="top-img__before"></div>

                        <img src="{{ asset('storage/' . $item->image) }}" alt="商品画像"class="top-img">
                        <div class="name-content">
                            <p class="top-name">
                                {{ $item->name }}
                            </p>
                        </div>
                    </div>
                </a>
                @endforeach
            </div>

        </div>
    </form>
</div>
@endsection
