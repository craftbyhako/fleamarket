@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{asset('css/chat.css')}}?v={{ time() }}">

@endsection

@section('content')
<div class="chat__content">
    <div class="chat__container">

        <aside class="chat__left-part">
            <h2 class="chat__left-part--title">その他の取引</h2>
            @foreach($pendingTrades as $pendingTrade)
            @if(in_array($pendingTrade->status, [1, 2]))
            <a href="{{ route('chat.show', $pendingTrade->id) }}">
                <p class="chat__left-part--pending_trades">{{ $pendingTrade->item->item_name }}</p>
            </a>
            @endif
            @endforeach
        </aside>


        <div class="chat__right-part">
            <div class="chat__header">

                <div class="chat__header--counterparty">
                    @if ($otherUser->profile_image && Storage::disk('public')->exists($otherUser->profile_image))
                    <img class="chat__header--counterparty-image"
                        src="{{ asset('storage/' . $otherUser->profile_image) }}"
                        alt="{{ $otherUser->user_name }}のプロフィール画像">
                    @else
                    <div class="chat__header--placeholder">
                        {{ mb_substr($otherUser->user_name, 0, 1) }}
                    </div>
                    @endif

                    <p class="chat__header--counterparty-title">{{ $otherUser->user_name }}さんとの取引画面 </p>
                </div>
                <button class="chat__complete-button" type="submit">取引を完了する</button>
            </div>

            <div class="chat__bought-item">
                <div class="chat__bought-item--wrapper">
                    <img class="chat__bought-item--image" src="{{ asset('storage/' . $trade->item->image) }}" alt="商品画像">

                    <div class="chat__bought-item--detail">
                        <p class="chat__bought-item--name">{{ $trade->item->item_name }}</p>
                        <p class="chat__bought-item--price">￥{{ $trade->item->price }}</p>
                    </div>
                </div>
            </div>

            <div class=" chat__messages">
                <div class="chat__messages-content">
                    @foreach($messages as $message)
                    <div class="{{ $message->is_me ? 'chat__messages-content--sent' : 'chat__message-content--received' }}">
                        <div class="chat__messages--user">
                            @if($message->display_image && Storage::disk('public')->exists($message->display_image))
                            <img class="chat__messages--profile-image" src="{{ asset('storage/' . $message->display_image) }}" alt="プロフィール画像">
                            @else
                            <div class="chat__messages--placeholder">
                                {{ mb_substr($message->display_name, 0, 1) }}
                            </div>
                            @endif
                            <p class="chat__messages--user-name">{{ $message->display_name }}</p>

                        </div>

                        @if ($message->is_me)
                        @if($editingId == $message->id)
                        <form action="{{ route('chat.update', $message->id) }}" method="POST">
                            @csrf
                            @method('PATCH')
                            <textarea name="content" rows="3">{{ $message->message }}</textarea>
                            <button type="submit">保存</button>
                        </form>
                        @else
                        <textarea class="chat__messages--text" readonly>{{ $message->message }}</textarea>
                        <div class="chat__messages--text-modify">
                            <a class="chat__messages--text-edit" href="{{ route('chat.show', ['sold_id' => $trade->id, 'edit' => $message->id]) }}">編集</a>

                            <form action="{{ route('chat.destroy', $message->id) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button class="chat__messages--text-edit" type="submit">削除</button>
                            </form>
                        </div>
                        @endif
                        @else
                        <textarea class="chat__messages--text" readonly>{{ $message->message }}</textarea>
                        @endif

                        @if($message->image)
                        <div class="chat__messages--image">
                            <a href="{{ asset('storage/' . $message->image) }}" target="_blank">
                                <img src="{{ asset('storage/' . $message->image) }}" alt="添付画像" style="max-width:150px;">
                            </a>
                        </div>
                        @endif

                    </div>
                    @endforeach
                </div>
            </div>

            <div class="chat__messages--create">
                <form class="chat__messages--create-form" action="{{ route('chat.store', ['sold_id' => $trade->id]) }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    @error('message')
                    <p class="error-message">{{ $message }}</p>
                    @enderror

                    @error('image')
                    <p class="error-message">{{ $message }}</p>
                    @enderror
                    <textarea class="chat__messages--create-form-text" name="message" placeholder="取引メッセージを記入してください">{{ session('draft_message_'.$trade->id, old('message')) }}</textarea>

                    <label class="chat__messages--create-form-upload" for="imageUpload">画像を追加</label>
                    <input type="file" id="imageUpload" name="image" accept="image/*">
                    <button class="chat__button-send" type="submit">📨</button>


                </form>
            </div>
        </div>
    </div>
</div>

@endsection