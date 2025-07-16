@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{asset('css/index.css')}}">

@endsection


@section('content')
<ul>
    <li><a class="index__menu" href="{{ url('/') }}">おすすめ</a></li>
    <li><a class="index__menu" href="{{ url('/?tab=mylist') }}">マイリスト</a></li>
</ul>

<div class="mylist">
    <div class="mylist__items">
        @foreach ($items as $item)
        <div class="mylist__item">
            <!-- 画像 -->
            <a href="{{ url('/item/' . $item->id) }}" class="item-link">
                <img src="{{ asset($item->image) }}" alt="商品画像" class="img-content">
            </a>
            <!-- 商品名 -->
            <div class="detail-content">
                <p>{{ $item->name }}</p>
            </div>
        </div>
        @endforeach
    </div>
</div>

@endsection