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
    <div class="price">￥{{ $item->price }} (税込）</div>

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
    
    @foreach( $item->categories as $category )
        <p>{{ $category->category_name }}</p>
    @endforeach


    <label for="condition">商品の状態</label>
    <P>{{ $item->condition->condition ?? '未設定' }}</P>

    <div class="item__comment-part">
        <h4>コメント({{ count($comments) }})</h4>
        
        @foreach ($comments as $comment)
            <div class="item__comment-part--content">
                <div class="comment__user">
                    <img src="{{ asset('strage/' . $comment->user->profile_image) }}" alt="プロフィール写真">
                    <p>{{$comment->user->user_name}}</p>
                </div>

            <div class="comment__body">
                <p>{{$comment->content}}</p>
            </div>
    </div>
        @endforeach


            <h4>商品へのコメント </h4>

            <!-- <form action="{{ route('comments.store') }}" method="POST">
            @csrf -->
                <textarea name="content" id="content" required></textarea>
                <input type="hidden" name="item_id" value="{{ $item->id }}">
            
                <button type="submit">コメントを送信する</button>
            <!-- </form> -->
    </div>

@endsection

