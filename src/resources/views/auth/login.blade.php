@extends('layouts.login_register')

@section('css')
<link rel="stylesheet" href="{{asset('css/login.css')}}">
@endsection

@section('content')

<div class="login__content">
    <h2 class="login__title">ログイン</h2>

    <form class="login-form" method="POST" action="{{ route('login') }}" novalidate>
    @csrf

    
        <label class="login__label" for="email">メールアドレス</label>
        <input class="login__input" type="email" name="email" value="{{ old('email') }}">
        <p class="login__error-message">
                    @error('email')
                    {{ $message }}
                    @enderror
        </p>

        <label class="login__label" for="password">パスワード</label>
        <input class="login__input" type="password" name="password">
        <p class="login__error-message">
                    @error('password')
                    {{ $message }}
                    @enderror
        </p>

        <button class="login__button-submit" type="submit">ログインする</button>
    </form>
    <!-- @if ($errors->any())
    <div class="error">{{ $errors->first() }}</div>
    @endif -->


    <div class="register__link">
        <a class="register__button-submit" href="/register">会員登録はこちら</a>
    </div>
</div>
@endsection