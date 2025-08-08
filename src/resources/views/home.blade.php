@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{asset('css/home.css')}}?v={{ time() }}">

@endsection


@section('content')
<ul class="home__menu">
    <li><a class="home__menu--item" href="/">おすすめ</a></li>
    <li><a class="home__menu--item" href="/mylist">マイリスト</a></li>
</ul>

<div class="home-list">
    <div class="home__items">
        @foreach ($items as $item)
        <div class="home__item">
            <a href="{{ url('/item/' . $item->id) }}" class="item-link">

            <!-- 画像 -->
            <img src="{{ asset('storage/'. $item->image) }}" alt="商品画像" class="img-content">

            <!-- 商品名 -->
            <div class="detail-content">
                <p class="detail-content__name">
                    {{ $item->item_name }}

                    @if ($item->sold)
                        <span class="sold-label">SOLD</span>
                    @endif
                    
                </p>
            </div>

            </a>
        </div>
        @endforeach
@endsection
       
       