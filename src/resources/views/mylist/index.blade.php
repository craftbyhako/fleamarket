@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{asset('css/index.css')}}">

@endsection


@section('content')
<ul>
    <li><a class="index__menu" href="src/resources/views/mypage/index.blade.php"></a>おすすめ</li>
    <li><a class="index__menu" href="http://"></a>マイリスト</li>
</ul>

<div class="mylist">
    <div class="mylist__items">
        @foreach ($items as $item)
        <div class="mylist__item">
            <!-- 画像 -->
            <a href="/item/:item_id" class="item-link"></a>
            <img src="{{ asset($item->image) }}" alt="商品画像" class="img-content">
            <!-- 商品名 -->
            <div class="detail-content">
                <p>{{ $item->name }}</p>
            </div>
        </div>
        @endforeach
    </div>
</div>

@endsection