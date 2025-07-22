@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{asset('css/index.css')}}?v={{ time() }}">
<!-- <style>
div {
  unicode-bidi: normal !important;
}
</style> -->
@endsection


@section('content')
<ul class="index__menu">
    <li><a class="index__menu--item" href="{{ url('/') }}">おすすめ</a></li>
    <li><a class="index__menu--item" href="{{ url('/?tab=mylist') }}">マイリスト</a></li>
</ul>

<div class="mylist">
    <div class="mylist__items">
        @foreach ($items as $item)
        <div class="mylist__item">
            
            <a href="{{ url('/item/' . $item->id) }}" class="item-link">
                <!-- 画像 -->
                <img src="{{ asset($item->image) }}" alt="商品画像" class="img-content">
            
                <!-- 商品名 -->
                <div class="detail-content">
                    <p class="detail-content__name">{{ $item->item_name }}</p>
                </div>
            </a>
        </div>
        @endforeach
    </div>
</div>

@endsection