@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{asset('css/item.css')}}?v={{ time() }}">

@endsection


@section('content')


<div class="item__left-part">
    <img src="{{ asset('storage/' . $item->image) }}" alt="商品画像">
</div>



<div class="item__right-part">
    <h2>{{$item->item_name}}</h2> 
    <div class="brand-name">{{ $item->brand_name }}</div>
    <div class="price">{{ $item->price }} (税込）</div>

    <!-- Like/Commentsのカウント -->
     <!-- DBからLike/Commentsの数を抽出する -->
    
     <button class="item__button" type="submit"> 購入手続きへ</button>
    <h3>商品説明</h3>
    <div>カラー：グレー</div>
    <div>新品</div>
    <div>商品の状態は良好です。傷もありません。</div>
    <div>購入後、即発送いたします。</div>


    <h3>商品の情報</h3>
    <label for="category">カテゴリー</label>
    <input type="text" name="category">
    @foreach( $item->categories as category )
    <p>{{ $category->category }}</p>
    @endforeach


    <label for="condition">商品の状態</label>
    <input type="text" name="condition">
    <P>{{ $item->condition->condition ?? '未設定' }}</P>

    <div class="item__comment-part">
        コメント({{ count($comments) }})
        
        @foreach ($comments as $comment)
        <div class="item__comment-part--content">
        {{$comment->content}}
        </div>
        @endforeach
   
            <img src="" alt="">
            <p> {{ $item->user->user_name }} </p>
            <div class="item__comment-part--content">
                {{$comment->content}}
            </div>

            <h4>商品へのコメント </h4>

            <textarea name="" id=""></textarea>

            <button type="submit">コメントを送信する</button>

    </div>
</div>

@endsection

