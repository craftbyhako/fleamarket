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
        <h1>{{ $item->item_name }}</h1> 
        
        @if(Auth::user()->likedItems->contains($item->id))
            <form action="{{ url('/items'. $item->id. 'like') }}" method="post">
                @csrf
                <button class="like-button" type="submit">いいね解除</button>
            </form>
        @else
            <form action="{{ url('/items'. $item->id. 'like') }}" method="post">
                @csrf
                <button class="like-button" type="submit">いいね！</button>
            </form>
        @endif

                <div class="brand-name">{{ $item->brand_name }}</div>
            <div class="price">￥{{ $item->price }} (税込）</div>

            <div class="item__actions">
                <div class="action__item">
                    <img src="{{ asset('storage/like.jpeg') }}" alt="">
                    <span class="count">{{ $item->likes_count ?? 0 }}</span>
                </div>
            

                <div class="action__item">
                    <img src="{{ asset('storage/comment.jpeg') }}" alt="">
                    <!-- <span class="comment-icon">💬</span> -->
                    <span class="count">{{ $item->comments_count ?? 0 }}</span>
                </div>
            </div>

            <button class="item__button" type="submit"> 購入手続きへ</button>
        <h2>商品説明</h2>
            <div>カラー：グレー</div>
            <div>新品</div>
            <div>商品の状態は良好です。傷もありません。</div>
            <div>購入後、即発送いたします。</div>


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
                <h3>コメント({{ count($comments) }})</h3>
        
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
                        <p>{{$comment->user->user_name}}</p>
                    </div>

                    <div class="comment__body">
                        <p>{{$comment->content}}</p>
                    </div>
                </div>
                @endforeach


                <h3>商品へのコメント </h3>

            <!-- <form action="{{ route('comments.store') }}" method="POST">
            @csrf -->
                <textarea name="content" id="content" required></textarea>
                <input type="hidden" name="item_id" value="{{ $item->id }}">
            
                <button class="item_button" type="submit">コメントを送信する</button>
            <!-- </form> -->
    </div>
</div>

@endsection

