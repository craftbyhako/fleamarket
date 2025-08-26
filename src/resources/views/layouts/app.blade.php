<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>fleamarket</title>
  <link rel="stylesheet" href="{{asset('css/sanitize.css')}}">
  <link rel="stylesheet" href="{{ asset('css/common.css')}}">
  @yield('css')
  
</head>

<body>
  <div class="app">
    <header class="header">
      <div class="header__inner">
        <a href="/"><img src="{{ asset('storage/logo.svg') }}" alt="coachtechロゴ"></a>

        <nav class="header__nav">

           <!-- 検索ボックス -->
      <div class="search-form">
        @auth
        <form class="header__form" action="{{ route('mylist') }}" method="GET" >

            <input type="hidden" name="tab" value="recommend">
            <input class="header__keyword" type="text" name="keyword"  placeholder="なにをお探しですか？" value="{{ old('keyword', $keyword ?? '') }}">
            <!-- <button class="header__button" type="submit" >検索</button>   -->
          </form>
        @else
          <form class="header__form" action="{{ route('home') }}" method="GET" >
            <input class="header__keyword" type="text" name="keyword" value="{{ old('keyword', $keyword ?? '') }}" placeholder="なにをお探しですか？">
            <!-- <button type="submit">検索</button> -->
        </form>
        @endauth 
      </div>
              

        @if (Auth::check())

          <!-- ログアウト -->
          <form class="header__form" action="{{ route('logout') }}" method="post">
            @csrf
            <button class="header__button" type="submit">ログアウト</button>
          </form>
        @else
          <!-- ログイン前：ログイン -->
          <div class="header__nav--item">
            <a href="/login">ログイン</a>
          </div>
        @endif

          <!-- マイページ -->
          <div class="header__nav--item">
            <a href="{{ route('user.adminMypage') }}">マイページ</a>
          </div>
          
          <!-- 出品 -->
          <div class="header__nav--item">
            <a href="{{ route('item.create') }}">出品</a>
          </div>
        </nav>
      </div>
      <!-- @yield('link') -->
    </header>

    
    <div class="content">
      @yield('content')
    </div>
  </div>
</body>

</html>