@extends('layouts.app')

@section('content')

<div class="container">
    <div class="row justify-content-center">
    {{-- 【開始】メインページ --}}
        <div id="top" class="top section-padding">
                <div class="row full-width">
                    <video class="video-slide active" controls autoplay muted loop>
                        <source src="{{ asset('videos/1.mp4') }}" type="video/mp4">
                    </video>
                    <video class="video-slide" controls autoplay muted loop>
                        <source src="{{ asset('videos/2.mp4') }}" type="video/mp4">
                    </video>
                    <video class="video-slide" controls autoplay muted loop>
                        <source src="{{ asset('videos/3.mp4') }}" type="video/mp4">
                    </video>
                    <video class="video-slide" controls autoplay muted loop>
                        <source src="{{ asset('videos/4.mp4') }}" type="video/mp4">
                    </video>


                    <div class="content">
                        <h1>みんなのレシピ</h1>
                        <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Inventore ducimus cum, pariatur aperiam nihil tempore officia molestiae est. Nihil laudantium cumque aspernatur deserunt quasi vitae consequatur? Animi sed voluptatum similique.</p>
                    </div>
                    <div class="slider-nav">
                        <a class="nav-btn " href="javascript:void(0);" onclick="changeVideo(0)"></a>
                        <a class="nav-btn" href="javascript:void(0);" onclick="changeVideo(1)"></a>
                        <a class="nav-btn" href="javascript:void(0);" onclick="changeVideo(2)"></a>
                        <a class="nav-btn" href="javascript:void(0);" onclick="changeVideo(3)"></a>
                    </div>
                </div>
        </div>
    </div>
</div>   




<div class="divider m-5"></div>




<div class="container">

    <div class="row m-5">
        <div class="col-12">
            <div class="intro-section text-center mb-4">
                <h1 class="fw-bold">今月のおすすめ</h1>
                <p class="mx-auto">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Dolorem quod alias veniam eveniet beatae facere inventore. Ab, facilis distinctio doloremque ullam, delectus libero illo illum corrupti, alias aliquam atque exercitationem?</p>
            </div>
        </div>
    </div>

    <div class="row justify-content-end">
        <div class="col-md-7">
            <div class="row justify-content-center">
                @foreach($randomImages as $key => $randomImage)
                        <div class="me-1 m-2 service border-hover p-4 shadow" style="background-image: url('{{ asset('storage/recipe_images/' . basename($randomImage->image)) }}'); background-size: cover; width: 15rem; height: 15rem;">
                        </div>
                    @if($key === 5) <!-- 3枚の画像を表示 -->
                        @break
                    @endif
                @endforeach
            </div>
        </div>
            {{-- 分割する線 --}}
            <div class="col-md-1 d-none d-md-block mx-2" style="width: 0;">
                <div class="mx-2" style="border-right: 1px solid rgba(0, 0, 0, 0.08); height: 100%"></div>
            </div>
            {{-- 分割する線 --}}


        <div class="col-md-4">
            <h3 class="mt-5"><span class="highlight-text">材料</span> key word</h3>
            {{-- TODO:これを「primary」部分に入れる！！<a href="{{ route('showRecipesByIngredient', ['ingredientName' => 'ここに材料名を挿入']) }}" class="badge rounded-pill bg-primary my-1 me-1">材料名</a> --}}
            
            <div class="mt-3">
                @foreach ($keywords as $keyword)
                <a href="{{ route('keywords.show', $keyword->id) }}" class="badge rounded-pill bg-primary my-1 me-1">{{ $keyword->name }}</a>
                @endforeach
                
                <div class="mt-5">
                    <h3 class="my-3"><span class="highlight-text">その他</span> key word</h3>
                    <span class="badge rounded-pill bg-primary my-1 me-1">時短！</span>
                    <span class="badge rounded-pill bg-primary my-1 me-1">節約！</span>
                    <span class="badge rounded-pill bg-primary my-1 me-1">子供が喜ぶ！</span>
                    <span class="badge rounded-pill bg-primary my-1 me-1">おつまみ！</span>
                    <span class="badge rounded-pill bg-primary my-1 me-1">冬レシピ</span>
                    <span class="badge rounded-pill bg-primary my-1 me-1">ヘルシー！</span>
                    <span class="badge rounded-pill bg-primary my-1 me-1">あともう一品！</span>
                </div>
                
            </div>
        </div>
    </div>
</div>

<div class="divider m-5"></div>

<div class="container">

    <div class="row m-5">
        <div class="col-12">
            <div class="intro-section text-center mb-4">
                <h1 class="fw-bold">ご当地のおすすめごはん</h1>
                <p class="mx-auto">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Dolorem quod alias veniam eveniet beatae facere inventore. Ab, facilis distinctio doloremque ullam, delectus libero illo illum corrupti, alias aliquam atque exercitationem?</p>
            </div>

            {{-- 日本地図 --}}
            <div id="japan-map" class="clearfix">

                <div id="hokkaido-touhoku" class="clearfix">
                    <p class="area-title">北海道・東北</p>
                    <div class="area">
                        {{-- <a href="#"> --}}
                            <div id="hokkaido">
                                <p>北海道</p>
                            </div>
                        {{-- </a> --}}
                        {{-- <a href="#"> --}}
                            <div id="aomori">
                                <p>青森</p>
                            </div>
                        {{-- </a> --}}
                        {{-- <a href="#"> --}}
                            <div id="akita">
                                <p>秋田</p>
                            </div>
                        {{-- </a> --}}
                        {{-- <a href="#"> --}}
                            <div id="iwate">
                                <p>岩手</p>
                            </div>
                        {{-- </a> --}}
                        {{-- <a href="#"> --}}
                            <div id="yamagata">
                                <p>山形</p>
                            </div>
                        {{-- </a> --}}
                        {{-- <a href="#"> --}}
                            <div id="miyagi">
                                <p>宮城</p>
                            </div>
                        {{-- </a> --}}
                        {{-- <a href="#"> --}}
                            <div id="fukushima">
                                <p>福島</p>
                            </div>
                        {{-- </a> --}}
                    </div>
                </div>
                
                <div id="kantou">
                    <p class="area-title">関東</p>
                    <div class="area">
                        {{-- <a href="#"> --}}
                            <div id="gunma">
                                <p>群馬</p>
                            </div>
                        {{-- </a> --}}
                        {{-- <a href="#"> --}}
                            <div id="tochigi">
                                <p>栃木</p>
                            </div>
                        {{-- </a> --}}
                        {{-- <a href="#"> --}}
                            <div id="ibaraki">
                                <p>茨城</p>
                            </div>
                        {{-- </a> --}}
                        {{-- <a href="#"> --}}
                            <div id="saitama">
                                <p>埼玉</p>
                            </div>
                        {{-- </a> --}}
                        {{-- <a href="#"> --}}
                            <div id="chiba">
                                <p>千葉</p>
                            </div>
                        {{-- </a> --}}
                        {{-- <a href="#"> --}}
                            <div id="tokyo">
                                <p>東京</p>
                            </div>
                        {{-- </a> --}}
                        {{-- <a href="#"> --}}
                            <div id="kanagawa">
                                <p>神奈川</p>
                            </div>
                        {{-- </a> --}}
                    </div>
                </div>
                
                <div id="tyubu" class="clearfix">
                    <p class="area-title">中部</p>
                    <div class="area">
                        {{-- <a href="#"> --}}
                            <div id="nigata">
                                <p>新潟</p>
                            </div>
                        {{-- </a> --}}
                        {{-- <a href="#"> --}}
                            <div id="toyama">
                                <p>富山</p>
                            </div>
                        {{-- </a> --}}
                        {{-- <a href="#"> --}}
                            <div id="ishikawa">
                                <p>石川</p>
                            </div>
                        {{-- </a> --}}
                        {{-- <a href="#"> --}}
                            <div id="fukui">
                                <p>福井</p>
                            </div>
                        {{-- </a> --}}
                        {{-- <a href="#"> --}}
                            <div id="nagano">
                                <p>長野</p>
                            </div>
                        {{-- </a> --}}
                        {{-- <a href="#"> --}}
                            <div id="gifu">
                                <p>岐阜</p>
                            </div>
                        {{-- </a> --}}
                        {{-- <a href="#"> --}}
                            <div id="yamanashi">
                                <p>山梨</p>
                            </div>
                        {{-- </a> --}}
                        {{-- <a href="#"> --}}
                            <div id="aichi">
                                <p>愛知</p>
                            </div>
                        {{-- </a> --}}
                        {{-- <a href="#"> --}}
                            <div id="shizuoka">
                                <p>静岡</p>
                            </div>
                        {{-- </a> --}}
                    </div>
                </div>
                
                <div id="kinki" class="clearfix">
                    <p class="area-title">近畿</p>
                    <div class="area">
                        {{-- <a href="#"> --}}
                            <div id="kyoto">
                                <p>京都</p>
                            </div>
                        {{-- </a> --}}
                        {{-- <a href="#"> --}}
                            <div id="shiga">
                                <p>滋賀</p>
                            </div>
                        </a>
                        {{-- <a href="#"> --}}
                            <div id="osaka">
                                <p>大阪</p>
                            </div>
                        {{-- </a> --}}
                        {{-- <a href="#"> --}}
                            <div id="nara">
                                <p>奈良</p>
                            </div>
                        {{-- </a> --}}
                        {{-- <a href="#"> --}}
                            <div id="mie">
                                <p>三重</p>
                            </div>
                        {{-- </a> --}}
                        {{-- <a href="#"> --}}
                            <div id="wakayama">
                                <p>和歌山</p>
                            </div>
                        {{-- </a> --}}
                        {{-- <a href="#"> --}}
                            <div id="hyougo">
                                <p>兵庫</p>
                            </div>
                        {{-- </a> --}}
                    </div>
                </div>
                
                <div id="tyugoku" class="clearfix">
                    <p class="area-title">中国</p>
                    <div class="area">
                        {{-- <a href="#"> --}}
                            <div id="tottori">
                                <p>鳥取</p>
                            </div>
                        {{-- </a> --}}
                        {{-- <a href="#"> --}}
                            <div id="okayama">
                                <p>岡山</p>
                            </div>
                        {{-- </a> --}}
                        {{-- <a href="#"> --}}
                            <div id="shimane">
                                <p>島根</p>
                            </div>
                        {{-- </a> --}}
                        {{-- <a href="#"> --}}
                            <div id="hiroshima">
                                <p>広島</p>
                            </div>
                        {{-- </a> --}}
                        {{-- <a href="#"> --}}
                            <div id="yamaguchi">
                                <p>山口</p>
                            </div>
                        {{-- </a> --}}
                    </div>
                </div>
                
                <div id="shikoku" class="clearfix">
                    <p class="area-title">四国</p>
                    <div class="area">
                        {{-- <a href="#"> --}}
                            <div id="kagawa">
                                <p>香川</p>
                            </div>
                        {{-- </a> --}}
                        {{-- <a href="#"> --}}
                            <div id="ehime">
                                <p>愛媛</p>
                            </div>
                        {{-- </a> --}}
                        {{-- <a href="#"> --}}
                            <div id="tokushima">
                                <p>徳島</p>
                            </div>
                        {{-- </a> --}}
                        {{-- <a href="#"> --}}
                            <div id="kouchi">
                                <p>高知</p>
                            </div>
                        {{-- </a> --}}
                    </div>
                </div>
                
                <div id="kyusyu" class="clearfix">
                    <p class="area-title">九州・沖縄</p>
                    <div class="area">
                        {{-- <a href="#"> --}}
                            <div id="fukuoka">
                                <p>福岡</p>
                            </div>
                        {{-- </a> --}}
                        {{-- <a href="#"> --}}
                            <div id="saga">
                                <p>佐賀</p>
                            </div>
                        {{-- </a> --}}
                        {{-- <a href="#"> --}}
                            <div id="nagasaki">
                                <p>長崎</p>
                            </div>
                        {{-- </a> --}}
                        {{-- <a href="#"> --}}
                            <div id="oita">
                                <p>大分</p>
                            </div>
                        {{-- </a> --}}
                        {{-- <a href="#"> --}}
                            <div id="kumamoto">
                                <p>熊本</p>
                            </div>
                        {{-- </a> --}}
                        {{-- <a href="#"> --}}
                            <div id="miyazaki">
                                <p>宮崎</p>
                            </div>
                        {{-- </a> --}}
                        {{-- <a href="#"> --}}
                            <div id="kagoshima">
                                <p>鹿児島</p>
                            </div>
                        {{-- </a> --}}
                        {{-- <a href="#"> --}}
                            <div id="okinawa">
                                <p>沖縄</p>
                            </div>
                        {{-- </a> --}}
                    </div>
                </div>
                
            </div>
            {{-- 日本地図 --}}
            
        </div>
    </div>


</div>

<div class="divider m-5"></div>


<script>
const videos = document.querySelectorAll(".video-slide");
const navButtons = document.querySelectorAll(".nav-btn");

function changeVideo(index) {
    // すべてのビデオを非表示にするために active クラスを削除
    videos.forEach(video => video.classList.remove("active"));

    // 選択されたビデオに active クラスを追加
    videos[index].classList.add("active");

    // ナビゲーションボタンのスタイルを変更
    navButtons.forEach(btn => btn.classList.remove("active"));
    navButtons[index].classList.add("active");
}

// 最初のビデオを表示
changeVideo(0);
</script>

<script src="{{ asset('/js/map.js') }}"></script>
    
@endsection
