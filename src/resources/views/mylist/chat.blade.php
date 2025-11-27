@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{asset('css/chat.css')}}?v={{ time() }}">

@endsection

@section('content')
<div class="chat__content">
    <div class="chat__container">

        <aside class="chat__left-part">
            <h3>その他の取引</h3>
            @if($pendingItems->sold->status ==2)
            <a href="{{ route('chat.show', $pendingItem->sold->id) }}">
                <p>{{ $pendingItem->item_name }}</p>
            </a>
            @endif
        </aside>


        <div class="chat__right-part">
            <div class="chat__header">
                <img src="{{ asset('storage/' . $user->image) }}" alt="{{ $user->user_nameのプロフィール画像 }}">
                <p>{{ $user->user_nameさんとの取引画面 }}</p>
                <button class="chat__complete-button">取引を完了する</button>
            </div>

            <div class="chat__bought-item">
                <div class="chat__bought-item-wrapper">
                    <img src="{{ asset('storage/' . $item->image) }}" alt="商品画像">
                    <h2>{{ $item->item_name }}</h2>
                    <p>{{ $item->price }}</p>
                </div>
            </div>

            <div class="chat__messages">
                <div class="chat__messages-content">
                    <div class="chat__messages-conten--sent">
                        <img class="chat__messages--profile-image" src="{{ asset('storage/' . $user->image) }}" alt="プロフィール画像">
                        <p>{{ $user->user_name }}</p>
                        <textarea name="chat__messages--text">
                        {{ $message->message }}
                        </textarea>

                        @if ('user_id', $user->id )
                        <a href="">編集</a>
                        <a href="">削除</a>
                        @endif
                    </div>

                    <div class="chat__messages-conten--received">
                        <img class="chat__messages--profile-image" src="{{ asset('storage/' . $user->image) }}" alt="プロフィール画像">
                        <p>{{ $user->user_name }}</p>
                        <textarea name="message_text">
                        {{ $message->message }}
                        </textarea>

                        @if ('user_id', $user->id )
                        <a href="">編集</a>
                        <a href="">削除</a>
                        @endif
                    </div>


                </div>
                <div class="chat__messages--create">
                    <form class="chat__messages--create-form" action="/chat/{sold_id}" method="POST" enctype="multipart/form-data">
                        <textarea class="chat__messages--create-form-text" name="new_message" id="">取引メッセージを記入してください</textarea>
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