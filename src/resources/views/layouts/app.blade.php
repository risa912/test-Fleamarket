<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>COACHTECH</title>
    <link rel="stylesheet" href="https://unpkg.com/ress/dist/ress.min.css">
    <link rel="stylesheet" href="{{ asset('css/common.css') }}">
    @yield('css')
</head>
<body>
    <div class="app">
        <header class="header">
          <div class="header__inner">
            <h1 class="header__logo">
              <a class="logo__link" href="{{ url('/') }}">
                <img class="logo__img" src="{{ asset('images/logo.svg') }}" alt="Logo">
              </a>
            </h1>

            @if(!Request::is('login') && !Request::is('register'))
            <div class="header__nav">
              <form class="header__search" action="{{ route('search') }}" method="GET">
                @csrf
                <input class="header__search-input" type="text" name="keyword" placeholder="なにをお探しですか？" value="{{ request('keyword') }}">
              </form>

              <nav class="header__menu">
                <form method="POST" action="{{ route('logout') }}">
                  @csrf
                  <button type="submit" class="header__link">ログアウト</button>
                </form>
                
                <a class="header__link" href="{{ route('mypage') }}">マイページ</a>

                <a href="{{ route('sell') }}" class="header__link--btn">出品</a>
              </nav>
            </div> 
            @endif
          </div>
        </header>


        <main class="content">
            @yield('content') 
        </main>
    </div>
    @yield('scripts')
</body>
</html>
