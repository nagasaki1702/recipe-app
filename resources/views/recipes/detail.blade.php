@extends('layouts.app')

@section('content')

<div class="container section-padding">
    <div class="row">
        <div class="col-md-8">
            <div class="recipe-info">
                <div class="text-center">
                    <img src="{{ asset('storage/recipe_images/' . basename($recipe->image)) }}" alt="{{ $recipe->title }}" class="img-thumbnail" style="width: 22rem;">
                </div>
                <h2 class="text-center">{{ $recipe->title }}</h2>

                <div class="star-rating mt-4 text-center">
                    <form id="rating-form" action="{{ route('recipe.rate', ['recipeId' => $recipe->id]) }}" method="POST">
                        @csrf <!-- CSRFトークンを追加 -->
                        <div class="d-flex justify-content-center align-items-center">
                            <div class="stars">
                                <span class="bi bi-star star" data-rating="1" style="color: {{ $userRating && $userRating->rating >= 1 ? '#FFD700' : '#FFD700' }}"></span>
                                <span class="bi bi-star star" data-rating="2" style="color: {{ $userRating && $userRating->rating >= 2 ? '#FFD700' : '#FFD700' }}"></span>
                                <span class="bi bi-star star" data-rating="3" style="color: {{ $userRating && $userRating->rating >= 3 ? '#FFD700' : '#FFD700' }}"></span>
                                <span class="bi bi-star star" data-rating="4" style="color: {{ $userRating && $userRating->rating >= 4 ? '#FFD700' : '#FFD700' }}"></span>
                                <span class="bi bi-star star" data-rating="5" style="color: {{ $userRating && $userRating->rating >= 5 ? '#FFD700' : '#FFD700' }}"></span>
                            </div>
                            <div class="ms-3 rating-button-container">
                                <input type="hidden" id="selected-rating" name="selected-rating" value="0">
                                <input type="hidden" name="recipeId" value="{{ $recipe->id }}">
                                <button type="button" id="submit-rating" class="btn btn-outline-warning btn-sm">評価する</button>
                            </div>
                        </div>
                    </form>
                    <p class="selected-stars-text">あなたの評価: <span class="selected-stars">0</span> / 5</p>
                    <div id="rating-success-message" style="display: none;" class="alert alert-success mt-2">評価しました！</div>
                </div>
                


            {{-- PDFダウンロードボタン --}}
            <div class="mt-4 text-center">
                <a href="{{ route('recipe.pdf', ['recipeId' => $recipe->id]) }}" class="btn btn-primary" target="_blank">
                    PDFをダウンロードする
                </a>
            </div>



                <div class="ingredients mt-3">
                    <h3>材料</h3>
                    <ul>
                        @foreach ($recipe->ingredients as $ingredient)
                        <li>{{ $ingredient->name }}: {{ $ingredient->quantity }} {{ $ingredient->unit }}</li>
                        @endforeach
                    </ul>
                </div>
                <div class="description mb-4">
                    <h3>説明</h3>
                    <p>{{ $recipe->description }}</p>
                </div>
            </div>

            {{-- ここにコメント欄 --}}
            @if (!is_null($comments) && count($comments) > 0)
                <div class="mt-5 mb-2"><h3>コメント</h3></div>
                <ul style="list-style-type: none;">
                    @foreach ($comments as $comment)
                        <li class="m-1">
                            @if ($comment->user->image)
                                <img src="{{ asset('storage/user_images/' . basename($comment->user->image)) }}" alt="{{ $comment->user->name }}" width="50" height="50" style="border-radius: 50%;">
                            @endif
                            @if ($comment->user->image) <!-- 画像が存在する場合 -->
                                {{ $comment->user->name }}: {{ $comment->comment }}
                            @else <!-- 画像が存在しない場合 -->
                                {{ $comment->user->name }}: {{ $comment->comment }}
                            @endif
                        </li>
                    @endforeach
                </ul>
            @else
                <p>コメントはありません。</p>
            @endif

            <!-- コメント投稿フォーム -->
            <div class="mt-5"><h3>コメントする</h3></div>
            <form action="{{ route('comments.store', ['recipeId' => $recipe->id]) }}" method="POST">
                @csrf
                <div class="mb-3">
                    <textarea class="form-control" id="comment" name="comment" rows="4"></textarea>
                </div>
                <div class="text-center mt-2 mb-3">
                    <button type="submit" class="btn btn-primary">　投 稿　</button>
                </div>
            </form>
        </div>

            {{-- 分割する線 --}}
            <div class="col-md-1 d-none d-md-block mx-4" style="width: 0;">
                <div class="ms-0" style="border-right: 1px solid rgba(0, 0, 0, 0.08); height: 100%"></div>
            </div>
            {{-- 分割する線 --}}

        <div class="col-md-3">
            <div class="user-info">
                <div class="user-profile text-center">
                    <label style="margin-bottom: 3px; text-align: left;"></label>
                    @if ($recipe->user->image)
                        <img src="{{ asset('storage/user_images/' . basename($recipe->user->image)) }}" alt="{{ $recipe->user->name }}" class="img-thumbnail mx-auto rounded-circle" style="width: 10rem; height: 10rem; display: block;">
                    @else
                        <img src="{{ asset('imgs/user-default.png') }}" alt="デフォルトアイコン" class="img-thumbnail mx-auto rounded-circle" style="width: 10rem; height: 10rem; display: block;">
                    @endif
                    <div class="mt-3">このレシピは</div>
                    <div class="user-name mb-3">{{ $recipe->user->name }}さんが投稿しました！</div>
                    @if ($recipe->user->introduction)
                    <div class="user-introduction ms-2" style="text-align: left; word-wrap: break-word;">
                        {{ $recipe->user->introduction }}</div>
                    @else
                        <p class="ms-2" style="text-align: left;">{{ $recipe->user->name }}さんの自己紹介はありません。</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function() {
        // 既存の評価を読み込む
        var userRating = {{ $userRating ? $userRating->rating : 0 }};
        updateSelectedStars(userRating);

        $('.star').on('click', function() {
            var rating = $(this).data('rating');
            $('#selected-rating').val(rating);
            updateSelectedStars(rating);
        });

        $('#submit-rating').on('click', function() {
            var selectedRating = $('#selected-rating').val();

            // AJAXリクエストを使用して評価情報をサーバーに送信
            $.ajax({
                type: 'POST',
                url: '{{ route('recipe.rate', ['recipeId' => $recipe->id]) }}',
                data: {
                    '_token': '{{ csrf_token() }}',
                    'selected-rating': selectedRating,
                    'recipeId': {{ $recipe->id }}
                },
                success: function(response) {
                    // サーバーからの成功レスポンスを処理
                    // 何らかのフィードバックをユーザーに表示
                    $('#rating-success-message').html('評価しました！').addClass('alert alert-warning').fadeIn('fast');
                    $('#submit-rating').prop('disabled', true); // 評価ボタンを無効にする
                    setTimeout(function() {
                        $('#rating-success-message').fadeOut('fast');
                    }, 1000); // 1秒後にメッセージを非表示にする
                },
                error: function(xhr) {
                    // エラーが発生した場合の処理
                    console.error(xhr);
                }
            });
        });

        function updateSelectedStars(rating) {
            $('.star').removeClass('selected');
            $('.star').each(function() {
                if ($(this).data('rating') <= rating) {
                    $(this).addClass('selected').removeClass('bi-star').addClass('bi-star-fill');
                } else {
                    $(this).removeClass('bi-star-fill').addClass('bi-star');
                }
            });
            $('.selected-stars').text(rating);
        }


    });
</script>
@endsection
