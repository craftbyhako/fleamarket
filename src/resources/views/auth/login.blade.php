@extends('layouts.login_register')

@section('css')
<link rel="stylesheet" href="{{asset('css/login.css')}}">
@endsection

@section('content')

<div class="login__content">
    <h2 class="title">ログイン</h2>

    <form class="login-form" method="POST" action="{{ route('login') }}" novalidate>
    @csrf

    
        <label for="email">メールアドレス</label>
        <input type="email" name="email" value="{{ old('email') }}"required>
        <div class="form__error">
                    @error('email')
                    {{ $message }}
                    @enderror
        </div>

        <label for="password">パスワード</label>
        <input type="password" name="password" required>
        <div class="form__error">
                    @error('password')
                    {{ $message }}
                    @enderror
        </div>

        <button class="login__button-submit" type="submit">ログイン</button>
    </form>
    @if ($errors->any())
    <div class="error">{{ $errors->first() }}</div>
    @endif


    <div class="register__link">
        <a class="register__button-submit" href="/register">会員登録はこちら</a>
    </div>
</div>