<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <link rel="icon" href="{{ asset('imgs/favicon.png') }}" type="image/x-icon">
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Recipe Typist</title>

    {{-- icon --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">

    <!-- CSS -->
    <link href="https://cdn.jsdelivr.net/npm/remixicon@3.5.0/fonts/remixicon.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('/css/style_map.css') }}">
    <link rel="stylesheet" href="{{ asset('/css/bootstrap.css') }}">
    <link rel="stylesheet" href="{{ asset('/css/style.css') }}">

</head>
<body>
<div id="app">
    <nav class="navbar fixed-top navbar-expand-md navbar-light bg-white shadow-sm">
        <div class="container">
            <a class="navbar-brand" href="{{ url('/home') }}">Recipe Typist</a>
            
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent"
                    aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <!-- 左側Navbar -->
                <ul class="navbar-nav me-auto">
                            <!-- ログインしている場合に表示 -->
                            @auth
                            
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" data-bs-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">料理名</a>
                                <div class="dropdown-menu" data-bs-popper="static" style="width: 430px;">
                                    <div><a class="dropdown-item" href="{{ route('recipes.index') }}">おすすめ</a></div>
                                    <div class="dropdown-divider"></div>

                                    <div class="carbo d-flex">
                                        <div class="me-3">        
                                            <a class="dropdown-item" href="#"><img src="{{ asset('imgs/1-1.png') }}" alt="ご飯ものの画像" class="img-fluid" width="30" height="30">ご飯</a>
                                        </div>
                                        <div class="me-3">
                                            <a class="dropdown-item" href="#"><img src="{{ asset('imgs/2-2.png') }}" alt="パスタの画像" class="img-fluid" width="30" height="30">麺類</a>
                                        </div>
                                        <div>
                                            <a class="dropdown-item" href="#"><img src="{{ asset('imgs/3-3.png') }}" alt="パンの画像" class="img-fluid" width="30" height="30">パン</a>
                                        </div>
                                    </div>

                                    <div class="dropdown-divider"></div>

                                    <div class="protein d-flex">
                                        <div class="me-3">
                                            <a class="dropdown-item" href="#"><img src="{{ asset('imgs/4-4.png') }}" alt="肉の画像" class="img-fluid" width="30" height="30">肉類</a>
                                        </div>
                                        <div class="me-3">
                                            <a class="dropdown-item" href="#"><img src="{{ asset('imgs/5-5.png') }}" alt="魚の画像" class="img-fluid" width="30" height="30">魚類</a>
                                        </div>
                                        <div>
                                            <a class="dropdown-item" href="#"><img src="{{ asset('imgs/6-6.png') }}" alt="魚の画像" class="img-fluid" width="30" height="30">たまご</a>
                                        </div>
                                    </div>

                                    <div class="dropdown-divider"></div>

                                    <div class="others d-flex">
                                        <div class="me-1">
                                            <a class="dropdown-item" href="#"><img src="{{ asset('imgs/7-7.png') }}" alt="スープの画像" class="img-fluid" width="30" height="30">スープ</a>
                                        </div>
                                        <div class="me-1">
                                            <a class="dropdown-item" href="#"><img src="{{ asset('imgs/8-8.png') }}" alt="ドリンクの画像" class="img-fluid" width="30" height="30">ドリンク</a>
                                        </div>
                                        <div>
                                            <a class="dropdown-item" href="#"><img src="{{ asset('imgs/9-9.png') }}" alt="スイーツの画像" class="img-fluid" width="30" height="30">スイーツ</a>
                                        </div>
                                    </div>
                                    
                                    <div class="dropdown-divider"></div>
                                    <a class="dropdown-item" href="#">全て見る</a>
                                </div>
                            </li>


                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" data-bs-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">投稿</a>
                                <div class="dropdown-menu" data-bs-popper="static">
                                    <a class="dropdown-item" href="{{ route('recipes.create') }}">レシピ投稿</a>
                                    <a class="dropdown-item" href="{{ route('videos.up') }}">動画投稿</a>
                                </div>
                            </li>
    

                                <li class="nav-item">
                                    <div class="navbar-collapse collapse">

                                        <ul class="navbar-nav ml-auto">                                
                                            <!-- 評価別のドロップダウン -->
                                            <li class="nav-item dropdown">
                                                <a class="nav-link dropdown-toggle" href="#" id="ratingDropdown" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                    評価別
                                                </a>
                                                <div class="dropdown-menu" aria-labelledby="ratingDropdown">
                                                    @for ($rating = 1; $rating <= 5; $rating++)
                                                        <a class="dropdown-item" href="{{ route('recipes.ratedIndex', ['desiredStar' => $rating]) }}">
                                                            @for ($i = 1; $i <= $rating; $i++)
                                                                <span class="bi bi-star-fill text-warning"></span>
                                                            @endfor
                                                            @for ($i = $rating + 1; $i <= 5; $i++)
                                                                <span class="bi bi-star"></span>
                                                            @endfor
                                                            {{-- 任意のテキスト表示 --}}
                                                            星{{ $rating }}つ
                                                        </a>
                                                    @endfor
                                                </div>
                                            </li>
                                        </ul>
                                    </div>                               
                                </li>


                                <li class="nav-item dropdown">
                                    <a class="nav-link dropdown-toggle" data-bs-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">管理者ページ</a>
                                    <div class="dropdown-menu" data-bs-popper="static">
                                        {{-- キーワードテーブルに材料名を登録するために、材料一覧を表示して、登録フォームも表示する --}}
                                        {{-- 使用するコントローラーはキーワードコントローラー --}}
                                        <a class="nav-link active" href="{{ route('ingredients.index') }}">バッジ登録</a>
                                        {{-- キーワードテーブルに登録された材料名を表示し、それを編集する画面を表示する --}}
                                        {{-- なので、ひとまず使用するコントローラーはキーワードコントローラー --}}
                                        <a class="nav-link active" href="{{ route('keywords.edit') }}">バッジ編集</a>

                                    </div>

                                </li>
    


                            @endauth
                        </ul>

                <!-- 右側Navbar -->
                <ul class="navbar-nav ms-auto">
                    @guest
                        @if (Route::has('login'))
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                            </li>
                        @endif
                        @if (Route::has('register'))
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                            </li>
                        @endif
                    @else
                    <!-- 検索フォーム -->
                    <form class="d-flex me-2" method="GET" action="{{ route('recipes.search') }}">
                        @csrf
                        <input class="form-control me-sm-2" type="search" name="query" placeholder="Search">
                        <button class="btn btn-primary my-2 my-sm-0" type="submit">Search</button>
                    </form>                        
                    <!-- // 検索フォーム -->

                    <!-- ログインユーザー名表示 -->
                    <li class="nav-item dropdown">
                        <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button"
                            data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                            {{ Auth::user()->name }}
                        </a>
                        <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                            <!-- アカウント情報を追加 -->
                            @auth
                                <a class="dropdown-item" href="{{ route('users.show', ['id' => Auth::user()->id]) }}">
                                    {{ __('アカウント情報') }}
                                </a>
                            @endauth

                            <a class="dropdown-item" href="{{ route('logout') }}"
                                onclick="event.preventDefault();
                                    document.getElementById('logout-form').submit();">
                                {{ __('Logout') }}
                            </a>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                @csrf
                            </form>
                        </div>
                    </li>
                    <!-- // ログインユーザー名表示 -->

                    @endguest
                </ul>
            </div>
        </div>
        
    </nav>

    <main class="py-4">
        @yield('content')
    </main>
</div>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@2.11.6/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="{{ asset('/js/app.js') }}"></script>
</body>
</html>
