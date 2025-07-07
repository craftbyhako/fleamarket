@extends('layouts.login_register')

@section('css')
<link rel="stylesheet" href="{{asset('css/register.css')}}">
@endsection

@section('content')
<div class= "register__content">
    <h2>会員登録</h2>
    <br>
    <form action="" method="POST">
        <div class="register__input-form">
            <label class="register__label" for="name">ユーザー名</label>
            <input type="text" name="name" value="{{ old('name') }}" required>
            <p class="register-form__error-message">
                @error('name')
                {{ $message }}
                @enderror
            </p>

            <label class="register__label" for="email">メールアドレス</label>
            <input type="email" name="email" value="{{ old('email') }}" required>
            <p class="register-form__error-message">
                @error('email')
                {{ $message }}
                @enderror
            </p>

            <label class="register__label" for="password">パスワード</label>
            <input type="password" name="password" value="" required>
            <p class="register-form__error-message">
                @error('password')
                {{ $message }}
                @enderror
            </p>

            <label class="register__label" for="comfirm-password">確認用パスワード</label>
             <input type="password" name="comfirm-password" value="" required>
            <p class="register__error-message">
                @error('comfirm-password')
                {{ $message }}
                @enderror
            </p>
        </div>

        <input class="register__input-form__btn" type="submit" value="登録する">
    </form>
    <div class="login__link">
        <a class="login__button-submit" href="/login">ログインはこちら</a>
    </div>