@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/index.css') }}">
@endsection

@section('content')
<div class="top-form">
    <div class="top-group">
        <div class="top-title">
            <a href="{{ url('/?tab=all&keyword=' . request('keyword')) }}"
                class="top-tab {{ $tab === 'all' ? 'active' : '' }}">
                おすすめ
            </a>

            <a href="{{ url('/?tab=mylist&keyword=' . request('keyword')) }}"
                class="top-tab {{ $tab === 'mylist' ? 'active' : '' }}">
                マイリスト
            </a>
        </div>

        <div class="top-contents">
            @foreach ($items as $item)
                <a href="{{ route('items.show', $item->id) }}" class="top-link">
                    <div class="top-content">
                        @if($item->purchases->count() > 0)
                            <span class="sold-label">Sold</span>
                        @endif
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
</div>
@endsection
