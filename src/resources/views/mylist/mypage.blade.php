@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{asset('css/mypage.css')}}?v={{ time() }}">

@endsection


@section('content')
<div class="mypage__content">
    <div class="mypage__profile-group">
        <div class="mypage__profile_image">
            @if($user->profile_image)
                <img class="profile_image" src="{{ asset('storage/' . $user->profile_image) }}" alt="プロフィール画像">
            @else
                <div class="mypage-profile__placeholder">
                        {{ strtoupper(substr(Auth::user()->user_name, 0, 1)) }}
                </div>
            @endif
        </div>
        <div class="mypage__user-name">
            {{ $user->user_name }}
        </div>
        <div class="mypage__profile-edit-button">
            <a class="mypage__edit-button" href="{{ url('/mypage/profile') }}">プロフィールを編集</a>
        </div>
    </div>

<!-- タブの設定部分 -->
    <ul class="mypage__tabs">
        <li class="{{ $tab === 'sell' ? 'active' : '' }}">
            <a href="{{ url()->current() }}?tab=sell">
            出品した商品
            </a>
        </li>
        <li class="{{ $tab === 'bought' ? 'active' : '' }}">
            <a href="{{ url()->current() }}?tab=bought">
            購入した商品
            </a>
        </li>
        <li class="{{ $tab === 'pending' ? 'active' : '' }}">
            <a href="{{ url()->current() }}?tab=pending">
            取引中の商品
            </a>
        </li>
    </ul>


<!-- タブ内容（出品・購入） -->
    <div class="mypage__tab">
        @if ($tab === 'sell')
            <div class="mypage__sell-group">       
                @foreach ($sellItems as $sellItem)
                    <div class="mypage__card">
                        <div class="mypage__image">
                            <img src="{{ asset('storage/' . $sellItem->image) }}" alt="{{ $sellItem->item_name }}">
                            <div class="mypage__item_name">
                    {{ $sellItem->item_name }}
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

        @elseif ($tab ==='bought')
            <div  class="mypage__bought-group">
                @forelse ($boughtItems as $boughtItem)
                        <div class="mypage__card">
                            <div class="mypage__image">
                                <img src="{{ asset('storage/' . $boughtItem->image) }}" alt="{{ $boughtItem->item_name }}">
                                <div class="mypage__item_name">
                                    {{ $boughtItem->item_name }}
                                </div>
                            </div>
                        </div>
                @empty
                    <p>購入した商品はありません。</p>
                @endforelse
            </div>
        
        @elseif ($tab === 'penging')
            <div class="mypage__pending-group">
                @forelse ($pendingItems as $pengdingItem)
                <div class="mypage__card">
                    <div class="mypage__image">
                        <img src="{{ asset('storage/' . $pengingItem->image) }}" alt="{{ $pengingItem->item_name }}">
                        <div class="mypage__item_name">
                            {{ $pendingItem->item_name }}
                        </div>
                    </div>
                </div>
                @empty
                    <p>取引中の商品はありません。</p>
                @endforelse
            </div>
        @endif
    </div>


</div>
@endsection