@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{asset('css/chat.css')}}?v={{ time() }}">

@endsection

@section('content')
<div class="chat__content">
    <div class="chat__container">

        <aside class="chat__left-part">
            <h3>その他の取引</h3>
            @foreach($pendingTrades as $pendingTrade)
                @if(in_array($pendingTrade->status, [1, 2]))
                    <a href="{{ route('chat.show', $pendingTrade->id) }}">
                        <p>{{ $pendingTrade->item->item_name }}</p>
                    </a>
                @endif
            @endforeach
        </aside>


        <div class="chat__right-part">
            <div class="chat__header">
                <img src="{{ asset('storage/' . $otherUser->profile_image) }}" alt="{{ $otherUser->user_name }}のプロフィール画像">
                <p>{{ $otherUser->user_name }}さんとの取引画面 </p>
                <button class="chat__complete-button" type="submit">取引を完了する</button>
            </div>

            <div class="chat__bought-item">
                <div class="chat__bought-item-wrapper">
                    <img src="{{ asset('storage/' . $trade->item->image) }}" alt="商品画像">
                    <h2>{{ $trade->item->item_name }}</h2>
                    <p>{{ $trade->item->price }}</p>
                </div>
            </div>

            <div class="chat__messages">
                <div class="chat__messages-content">
                    @foreach($messages as $message)
                        <div class="{{ $message->is_me ? 'chat__messages-content--sent' : 'chat__message-content--received' }}">
                            <img class="chat__messages--profile-image" src="{{ asset('storage/' . $message->display_image) }}" alt="プロフィール画像">
                            <p>{{ $message->display_name }}</p>
                            <textarea class="chat__messages--text">{{ $message->message }}</textarea>

                            @if ($message->is_me)
                                <a href="">編集</a>
                                <a href="">削除</a>
                            @endif
                        </div>
                    @endforeach
                </div>
                
                <div class="chat__messages--create">
                    <form class="chat__messages--create-form" action="{{ route('chat.store', $trade->id) }}" method="POST">
                        @csrf
                        <textarea class="chat__messages--create-form-text" name="new_message" placeholder="取引メッセージを記入してください"></textarea>

                        <label class="chat__messages--create-form-upload" for="imageUpload">画像を追加</label>
                        <input type="file" id="imageUpload" name="profile_image" accept="image/*">
                        <button type="submit">✈</button>

                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection