@extends('layouts.login_register')

@section('css')
<link rel="stylesheet" href="{{asset('css/profile.css')}}">

@endsection

@section('content')
<div class= "register__content">
    <h2 class="register__title">会員登録</h2>
    <br>
    <form class="register-form" action="/register" method="POST" novalidate>
        @csrf
        <div class="register__input-form">
            <label class="register__label" for="user_name">ユーザー名</label>
            <input type="text" name="user_name" value="{{ old('user_name') }}" >
                <p class="register-form__error-message">
                @error('user_name')
                {{ $message }}
                @enderror
                </p>

            <label class="register__label" for="email">メールアドレス</label>
            <input type="email" name="email" value="{{ old('email') }}" >
                <p class="register-form__error-message">
                @error('email')
                {{ $message }}
                @enderror
                </p>

            <label class="register__label" for="password">パスワード</label>
            <input type="password" name="password" value="" >
                <p class="register-form__error-message">
                @error('password')
                {{ $message }}
                @enderror
                </p>

            <label class="register__label" for="password_confirmation">確認用パスワード</label>
            <input type="password" name="password_confirmation" value="" >
                <p class="register__error-message">
                @error('password_comfirmation')
                {{ $message }}
                @enderror
                </p>
        </div>

        <div class="register__input-form__button">
            <button type="submit">登録する</button>
        </div>
    </form>
    <div class="login__link">
        <a class="login__button-submit" href="/login">ログインはこちら</a>
    </div>
@endsection