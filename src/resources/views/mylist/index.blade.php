@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{asset('css/index.css')}}?v={{ time() }}">

@endsection


@section('content')

<ul class="index__menu">
    <li>
        <a class="index__menu--item {{ $tab === 'recommend' || $tab === '' ? 'active' : '' }}" href="{{ url('/mylist?tab=recommend&keyword=' . ($keyword ?? '')) }}">
            おすすめ
        </a>
    </li>
    <li>
        <a class="index__menu--item {{ $tab === 'mylist' ? 'active' : '' }}" href="{{ url('/mylist?tab=mylist&keyword=' . ($keyword ?? '')) }}">
            マイリスト
        </a>
    </li>
</ul>

<div class="mylist">
    <div class="mylist__items">
        @if($tab === 'mylist')
            @auth
                @if($items->isEmpty())
                    <p>マイリストに商品がありません。</p>
                @else
                    @foreach ($items as $item)
                        <!-- マイリスト商品表示 -->
                         <div class="mylist__item">
                            <a href="{{ url('/item/' . $item->id) }}" class="item-link">
                                <!-- 画像 -->
                                <img src="{{ asset('storage/' .$item->image) }}" alt="商品画像" class="img-content">
            
                                <!-- 商品名 -->
                                <div class="detail-content">
                                    <p class="detail-content__name">
                                    {{ $item->item_name }}

                                    @if ($item->isSold)
                                        <span class="sold-label">SOLD</span>
                                    @endif
                                    </p>
                                </div>
                            </a>
                        </div>
                    @endforeach
                @endif
            @else
                <p>ログインしてください。</p>
            @endauth
            @else
                @if($items->isEmpty())
                    <p>おすすめの商品がありません。</p>
                @else
                    @foreach ($items as $item)
                    <!-- {{-- おすすめ表示 --}} -->
                        <div class="mylist__item">
            
                             <a href="{{ url('/item/' . $item->id) }}" class="item-link">
                                <!-- 画像 -->
                                <img src="{{ asset('storage/' .$item->image) }}" alt="商品画像" class="img-content">
            
                                <!-- 商品名 -->
                                <div class="detail-content">
                                    <p class="detail-content__name">
                                        {{ $item->item_name }}
                         
                                    <!-- soldout表示 -->
                                    @if ($item->isSold)
                                        <span class="sold-label">SOLD</span>
                                    @endif
                                    </p>
                                </div>
                            </a>
                        </div>
                    @endforeach
                @endif
        @endif
    </div>
</div>

@endsection