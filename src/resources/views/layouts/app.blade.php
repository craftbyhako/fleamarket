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
        <h1 class="header__heading">COACHTECH</h1>
        @if (Auth::check())
        <nav class="header__nav">

           <!-- 検索ボックス -->
          <form class="header__form" action="/" method="GET" >
            <input class="header__keyword" type="text" name="keyword"  placeholder="なにをお探しですか？">
            <button class="header__button" type="submit" >検索</button>  
          </form>

          <!-- ログアウト -->
          <form class="header__form" action="/logout" method="post">
            @csrf
            <button class="header__button" type="submit">ログアウト</button>
          </form>
          
          <!-- マイリスト -->
          <form class="header__form" action="/?tab=mylist" method="GET">
            <button class="header__button" type="submit">マイページ</button>
          </form>
          
          <!-- 出品 -->
          <form class="header__form" action="/sell" method="get">
            <button class="header__button" type="submit">出品</button>
          </form>
        </nav>
        @endif
      </div>
      <!-- @yield('link') -->
    </header>

    
    <div class="content">
      @yield('content')
    </div>
  </div>
</body>

</html>