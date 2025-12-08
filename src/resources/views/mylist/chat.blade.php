@extends('layouts.login_register')

@section('css')
<link rel="stylesheet" href="{{ asset('css/chat.css') }}?v={{ time() }}">
@endsection

@section('content')
<div class="chat__content">
    <div class="chat__container">

        <!-- 左サイドバー：その他取引 -->
        <aside class="chat__left-part">
            <h2 class="chat__left-part--title">その他の取引</h2>
            @foreach($pendingTrades as $pendingTrade)
            @if(in_array($pendingTrade->status, [1, 2]))
            <form action="{{ route('chat.show', ['sold_id' => $pendingTrade->id]) }}" method="POST">
                @csrf
                <input type="hidden" name="draft_message" class="sidebar-draft-input" value="{{ $draftMessage ?? '' }}">
                <input type="hidden" name="input_sold_id_for_draft" value="{{ $trade->id }}">
                <button type="submit" class="chat__left-part--pending_trades-button">
                    {{ $pendingTrade->item->item_name }}
                </button>
            </form>
            @endif
            @endforeach
        </aside>

        <!-- 右メイン：取引画面 -->
        <div class="chat__right-part">

            <!-- 取引相手 -->
            <div class="chat__header">
                <div class="chat__header--counterparty">
                    @if ($otherUser->profile_image && Storage::disk('public')->exists($otherUser->profile_image))
                    <img class="chat__header--counterparty-image" src="{{ asset('storage/' . $otherUser->profile_image) }}" alt="{{ $otherUser->user_name }}のプロフィール画像">
                    @else
                    <div class="chat__header--placeholder">{{ mb_substr($otherUser->user_name, 0, 1) }}</div>
                    @endif
                    <p class="chat__header--counterparty-title">{{ $otherUser->user_name }}さんとの取引画面</p>
                </div>

                @if (Auth::user()->id == $trade->user_id && $trade->status < 3)
                    <a href="{{ route('chat.show', ['sold_id' => $trade->id, 'open' => 'buyer']) }}" class="chat__complete-button">取引を完了する</a>
                    @endif
            </div>

            <!-- 購入商品 -->
            <div class="chat__bought-item">
                <div class="chat__bought-item--wrapper">
                    <img class="chat__bought-item--image" src="{{ asset('storage/' . $trade->item->image) }}" alt="商品画像">
                    <div class="chat__bought-item--detail">
                        <p class="chat__bought-item--name">{{ $trade->item->item_name }}</p>
                        <p class="chat__bought-item--price">￥{{ $trade->item->price }}</p>
                    </div>
                </div>
            </div>

            <!-- メッセージ閲覧 -->
            <div class="chat__messages">
                @foreach($messages as $message)
                <div class="chat__messages-content {{ $message->is_me ? 'sent' : 'received' }}">
                    <div class="chat__messages--user">
                        @if($message->display_image && Storage::disk('public')->exists($message->display_image))
                        <img class="chat__messages--profile-image" src="{{ asset('storage/' . $message->display_image) }}" alt="プロフィール画像">
                        @else
                        <div class="chat__messages--placeholder">{{ mb_substr($message->display_name, 0, 1) }}</div>
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

            <!-- メッセージ作成 -->
            <div class="chat__messages--create">
                <form class="chat__messages--create-form" action="{{ route('chat.store', ['sold_id' => $trade->id]) }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    @error('draft_message')
                    <p class="error-message">{{ $message }}</p>
                    @enderror

                    @error('image')
                    <p class="error-message">{{ $message }}</p>
                    @enderror

                    <textarea class="chat__messages--create-form-text" name="draft_message" placeholder="取引メッセージを記入してください">{{ old('draft_message', $draftMessage) }}</textarea>

                    <label class="chat__messages--create-form-upload" for="imageUpload">画像を追加</label>
                    <input type="file" id="imageUpload" name="image" accept="image/*">

                    <button class="chat__button-send" type="submit" name="send_message" value="1">📨</button>
                </form>
            </div>

        </div>

        <!-- 取引完了モーダル -->
        <div class="chat__modal {{ $shouldShowRatingModal ? 'active' : '' }}">
            <div class="chat__modal-content">
                <h2 class="chat__modal-content--information">取引が完了しました。</h2>
                <p class="chat__modal-content--question">今回の取引相手はどうでしたか？</p>
                <form method="POST" action="{{ route('chat.complete', $sold_id) }}">
                    @csrf
                    <div class="rating">
                        <input type="radio" id="star5" name="rating" value="5" required /><label for="star5">★</label>
                        <input type="radio" id="star4" name="rating" value="4" /><label for="star4">★</label>
                        <input type="radio" id="star3" name="rating" value="3" /><label for="star3">★</label>
                        <input type="radio" id="star2" name="rating" value="2" /><label for="star2">★</label>
                        <input type="radio" id="star1" name="rating" value="1" /><label for="star1">★</label>
                    </div>
                    <div class="chat__modal-footer">
                        <button class="chat__modal-button" type="submit">送信する</button>
                    </div>

                </form>
            </div>
        </div>

    </div>
</div>

<!-- JS: 下書き同期 -->
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const mainTextarea = document.querySelector('.chat__messages--create-form-text');
        const draftInputs = document.querySelectorAll('.sidebar-draft-input');

        mainTextarea.addEventListener('input', () => {
            draftInputs.forEach(input => {
                input.value = mainTextarea.value;
            });
        });
    });
</script>

@endsection