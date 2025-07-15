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
      <h1 class="header__heading">COACHTECH</h1>
        <nav class="header__nav">
            <ul class="header__list">

                @if (Auth::check())
                 <!-- 検索ボックス -->
                <li class="header__list-item">
                    <form class="header__form" action="/ class="header__form" method="get">
                          @csrf
                          <input type="text" name="keyword" class="keyword" placeholder="なにをお探しですか？">
                            <button type="submit" class="submit-button">検索</button>  
                    </form>
                </li>

                    <!-- ログアウト -->
                <li class="header__list-item">
                    <form class="header__form" action="/logout" method="post">
                            @csrf
                            <button class="header__form--logout" type="submit">ログアウト</button>
                    </form>
                </li>

                    <!-- マイページ -->
                <li class="header__list-item">
                    <form class="header__form" action="/?tab=mylist" method="GET">
                            @csrf
                            <button class="header__form--mypage" type="button">マイページ</button>
                    </form>
                </li>

                    <!-- 出品 -->
                <li class="header__list-item">
                    <form class="header__form" action="/sell" method="get">
                            @csrf
                            <button class="header__form--sell" type="button">出品</button>
                    </form>
                </li>
                @endif
            </ul>
        </nav>

      <!-- @yield('link') -->
    </header>
    <div class="content">
      @yield('content')
    </div>
  </div>
</body>

</html>