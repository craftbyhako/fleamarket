@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{asset('css/profile.css')}}">

@endsection

@section('content')
<div class= "profile__content">
    <h2 class="profile__title">プロフィール設定</h2>
    <br>
    <form class="profile-form" action="{{ route('user.storeProfile') }}" method="POST" enctype="multipart/form-data" novalidate>
        @csrf

        <!-- プロフィール画像欄 -->
        <div class="profile__picture-group">
            <div class="profile__image-wrapper">
                @if(Auth::check() && Auth::user()->profile_image)
                    <img class="profile__image" src="{{ asset('storage/' . Auth::user()->profile_image) }}" alt="プロフィール写真" >
                @else
                    <div class="no-image">画像なし</div>
                @endif
            </div>

                
            <div class="profile__image-upload">
                <input type="file" id="file" name="profile_image" hidden>
                <label for="file" class="profile__image-label">画像を選択する</label>
            </div>
        </div>

        <!-- ユーザー情報追加入力欄 -->
        <div class="profile__input-form">
            <div class="profile__field">
                <label class="profile__label" for="user_name">ユーザー名</label>
                <input class="profile__input" type="text" name="user_name" value="{{ old('user_name', $defaultUserName) }}" >
            </div>
            <p class="profile-form__error-message">
                @error('user_name')
                    {{ $message }}
                @enderror
            </p>
            
            <div class="profile__field">
                <label class="profile__label" for="postcode">郵便番号</label>
                <input class="profile__input" type="text" name="postcode" value="{{ old('postcode') }}" >
            </div>
            <p class="profile-form__error-message"> 
                @error('postcode')
                    {{ $message }}
                @enderror
            </p>
               
            <div class="profile__field">
                <label class="profile__label" for="address">住所</label>
                <input class="profile__input" type="text" name="address" value="{{ (old('address')) }}" >
                
            </div>
            <p class="profile-form__error-message">
                @error('address')                
                    {{ $message }}
                @enderror
            </p>  
            
            <div class="profile__field">
                <label class="profile__label" for="building">建物名</label>
                <input class="profile__input" type="text" name="building" value="{{ old('building') }}" >
            </div>
            <p class="profile-form__error-message">
                @error('building')                    
                    {{ $message }}
                @enderror
            </p>
        </div>

        <div class="profile__input-form__button">
            <button type="submit">更新する</button>
        </div>
    </form>
    
@endsection