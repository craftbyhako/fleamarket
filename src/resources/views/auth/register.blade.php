@extends('layouts.login_register')

@section('css')
<link rel="stylesheet" href="{{asset('css/register.css')}}">
@endsection

@section('content')
<div class= "register__content">
    <h2>会員登録</h2>
    <br>
    <form class="register-form" action="/register" method="POST" novalidate>
        @csrf
        <div class="register__input-form">
            <label class="register__label" for="name">ユーザー名</label>
            <input type="text" name="name" value="{{ old('name') }}" >
            <p class="register-form__error-message">
                @error('name')
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

        <input class="register__input-form__btn" type="submit" value="登録する">
    </form>
    <div class="login__link">
        <a class="login__button-submit" href="/login">ログインはこちら</a>
    </div>