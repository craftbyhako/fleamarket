@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{asset('css/edit_profile.css')}}">

@endsection

@section('content')
<div class= "edit-profile__content">
    <h2 class="edit-profile__title">プロフィール設定</h2>
    <br>
    <form class="edit-profile__form" action="/mypage/profile" method="POST" enctype="multipart/form-data" novalidate>
        @csrf
        @method('PATCH')

        <!-- プロフィール画像欄 -->
        <div class="edit-profile__img-group">
            <!-- <div class="edit-profile__img"> -->
                @if(Auth::check() && Auth::user()->profile_image)
                    <img class="edit-profile__img" src="{{ asset('storage/' . Auth::user()->profile_image) }}" alt="プロフィール写真" style="max-width: 100%; height: auto;">
                @else
                    <div class="edit-profile__placeholder">
                        {{ strtoupper(substr(Auth::user()->user_name, 0, 1)) }}
                    </div>
                @endif

                <input type="file" id="file" name="profile_image" hidden>
                <label for="file" class="edit-profile__image-label">画像を選択する</label>
                <!-- <p class="register-form__error-message">
                @error('user_name')
                    {{ $message }}
                @enderror
                </p> -->
            </div>
        </div>

        <!-- ユーザー情報追加入力欄 -->
        <div class="edit-profile__input-form">
            <label class="edit-profile__label" for="user_name">ユーザー名</label>
            <input class="edit-profile__input" type="text" name="user_name" value="{{ old('user_name', $user->user_name) }}" >
                <p class="edit-profile__error-message">
                @error('user_name')
                {{ $message }}
                @enderror
                </p>

            <label class="edit-profile__label" for="postcode">郵便番号</label>
            <input class="edit-profile__input" type="text" name="postcode" value="{{ old('postcode', $user->postcode) }}" >
                <p class="edit-profile__error-message">
                @error('postcode')
                {{ $message }}
                @enderror
                </p>

            <label class="edit-profile__label" for="address">住所</label>
            <input class="edit-profile__input" type="text" name="address" value="{{ (old('address', $user->address)) }}" >
                <p class="edit-profile__error-message">
                @error('address')
                {{ $message }}
                @enderror
                </p>

            <label class="edit-profile__label" for="building">建物名</label>
            <input class="edit-profile__input" type="text" name="building" value="{{ old('building', $user->building) }}" >
                <p class="edit-profile__error-message">
                @error('building')
                {{ $message }}
                @enderror
                </p>
        </div>

        <div class="edit-profile__button">
            <button type="submit">更新する</button>
        </div>
    </form>
    
@endsection