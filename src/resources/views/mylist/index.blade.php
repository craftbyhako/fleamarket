@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{asset('css/index.css')}}?v={{ time() }}">

@endsection


@section('content')
<ul class="index__menu">
    <li><a class="index__menu--item" href="{{ url('/') }}">おすすめ</a></li>
    <li><a class="index__menu--item" href="{{ url('/?tab=mylist') }}">マイリスト</a></li>
</ul>

<div class="mylist">
    <div class="mylist__items">
        @if($tab === 'mylist')

            @auth
                @if($items->isEmpty())
                <p>マイリストに商品がありません。</p>
                @else
                    @foreach ($items as $item)
                        <!-- {{ dd($item) }}  -->
                        <div class="mylist__item">
            
                             <a href="{{ url('/item/' . $item->id) }}" class="item-link">
                <!-- 画像 -->
                                <img src="{{ asset($item->image) }}" alt="商品画像" class="img-content">
            
                <!-- 商品名 -->
                                <div class="detail-content">
                                    <p class="detail-content__name">
                                        {{ $item->item_name }}
                         
                        <!-- soldout表示 -->
                                    @if ($item->sold)
                                        <span class="sold-label">SOLD</span>
                                    @endif
                                    </p>

                    <!-- <p>出品者: {{ $item->user->name ?? '不明' }} -->

                                </div>
                            </a>
                        </div>
                    @endforeach
                @endif
            @endauth
        @endif
    </div>
</div>

@endsection