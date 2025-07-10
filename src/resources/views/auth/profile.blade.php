@extends('layouts.login_register')

@section('css')
<link rel="stylesheet" href="{{asset('css/profile.css')}}">

@endsection

@section('content')
<div class= "profile__content">
    <h2 class="profile__title">プロフィール設定</h2>
    <br>
    <form class="profile-form" action="/profile" method="POST" novalidate>
        @csrf

        <!-- アイコン設定 -->
        <div class="profile__picture-group">
            <div class="profile__img">
                <img src="" alt="プロフィール写真">
            </div>
            <div class="profile__select-button">
                <button type="">画像を選択する</button>
            </div>

        <!-- ユーザー情報追加入力欄 -->
        <div class="profile__input-form">
            <label class="profile__label" for="user_name">ユーザー名</label>
            <input type="text" name="user_name" value="{{ old('user_name') }}" >
                <p class="register-form__error-message">
                @error('user_name')
                {{ $message }}
                @enderror
                </p>

            <label class="profile__label" for="postcode">郵便番号</label>
            <input type="text" name="postcode" value="{{ old('postcode') }}" >
                <p class="profile-form__error-message">
                @error('postcode')
                {{ $message }}
                @enderror
                </p>

            <label class="profile__label" for="address">住所</label>
            <input type="text" name="address" value="{{ old('address') }}" >
                <p class="profile-form__error-message">
                @error('address')
                {{ $message }}
                @enderror
                </p>

            <label class="profile__label" for="building">建物名</label>
            <input type="text" name="building" value="{{ old('building') }}" >
                <p class="profile__error-message">
                @error('building')
                {{ $message }}
                @enderror
                </p>
        </div>

        <div class="register__input-form__button">
            <button type="submit">更新する</button>
        </div>
    </form>
    
@endsection