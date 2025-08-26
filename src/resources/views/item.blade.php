@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{asset('css/item.css')}}?v={{ time() }}">

@endsection


@section('content')
<div class="item__all-contents">
    <div class="item__left-part">

        <img class="item__img" src="{{ asset('storage/' . $item->image) }}" alt="商品画像">
    </div>



    <div class="item__right-part">
        <!-- 商品名 -->
        <h1>{{ $item->item_name }}</h1> 

        <!-- ブランド名 -->
        <div class="brand-name">{{ $item->brand }}</div>
        
        <!-- 値段 -->
        <div class="price">￥{{ number_format($item->price) }} (税込）</div>

        
@auth
    @php
        $isLiked = Auth::user()->likedItems->contains($item->id);
    @endphp

    <div class="item__actions">
        <!-- いいね数の表示-->
        <div class="action__item">
            <form action="{{ url('/items/' . $item->id . '/like') }}" method="POST">
                @csrf
                <button type="submit" class="like-button">
                    <img src="{{ asset($isLiked ? 'storage/like_red.jpeg' : 'storage/like_black.jpeg') }}" alt="いいね画像" class="like-image  {{ $isLiked ? 'liked' : '' }}">
                </button>
            </form>
            <span class="count">{{ $item->likes_count ?? 0 }}</span>
        </div>
               
        <!-- コメント数の表示 -->
        <div class="action__item">
            <img src="{{ asset('storage/comment.jpeg') }}" alt="コメント画像" >
            <span class="count">{{ $item->comments_count ?? 0 }}</span>
        </div>
    </div>
@endauth

            <!-- 購入手続きのリンクボタン -->
            <a href="{{ route('purchase.form', ['item' => $item->id]) }}" class="item__button">
                購入手続きへ
            </a>
        
        <!-- 商品説明     -->
         <div class="item__description">
            <h2>商品説明</h2>
                <p>{{ $item->description }}</p>
                <p>購入後、即発送いたします。</p>

        </div>
        <h2>商品の情報</h2>
            <div class="item__category">
                <label class="item__label--item" for="category">カテゴリー</label>
    
                @foreach( $item->categories as $category )
                <p class="item__info--item" >{{ $category->category_name }}</p>
                @endforeach
            </div>
            

            <div class="item__category">
                <label class="item__label--item" for="condition">商品の状態</label>
                <P>{{ $item->condition->condition ?? '未設定' }}</P>

            </div>

            <div class="item__comment-part">
                <h3 class="item__comment-count">コメント({{ count($comments) }})</h3>
        
                @foreach ($comments as $comment)
                <div class="item__comment-part--content">
                    <div class="comment__user">
                    @if ($comment->user->profile_image)
                        <img class="profile-img" src="{{ asset('storage/' . $comment->user->profile_image) }}" alt="プロフィール写真">
                    @else
                        <div class="profile-placeholder">
                            {{ strtoupper(substr($comment->user->user_name, 0, 1)) }}
                        </div>
                    @endif
                        <p class="comment-user">{{$comment->user->user_name}}</p>
                    </div>

                    <div class="comment__body">
                        <p class="comment-content">{{$comment->content}}</p>
                    </div>
                </div>
                @endforeach


                <h3>商品へのコメント </h3>

            <form action="{{ route('comments.store') }}" method="POST" novalidate>
            @csrf
                <textarea class="item__comment-textarea" name="content" id="content" required></textarea>
                <input type="hidden" name="item_id" value="{{ $item->id }}" >
                    <p class="item__comment-error-message">
                            @error('content')
                            {{ $message }}
                            @enderror
                    </p>
                <button class="item__comment-button" type="submit">コメントを送信する</button>
            </form>
    </div>
</div>

@endsection

