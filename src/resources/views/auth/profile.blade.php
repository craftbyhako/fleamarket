@extends('layouts.login_register')

@section('css')
<link rel="stylesheet" href="{{asset('css/profile.css')}}">

@endsection

@section('content')
<div class= "profile__content">
    <h2 class="profile__title">プロフィール設定</h2>
    <br>
    <form class="profile-form" action="/mypage" method="POST" enctype="multipart/form-data" novalidate>
        @csrf

        <!-- プロフィール画像欄 -->
        <div class="profile__picture-group">
            <div class="profile__img">
                @if(Auth::user()->profile_image)
                    <img src="{{ asset('storage/' . Auth::user()->profile_image) }}" alt="プロフィール写真" style="max-width: 100%; height: auto;">
                @else
                    <p>画像なし</p>
                @endif

                <input type="file" id="file" name="image" hidden>
                <label for="file" class="profile__img-label">画像を選択</label>
                <p class="register-form__error-message">
                @error('user_name')
                    {{ $message }}
                @enderror
                </p>
            </div>
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