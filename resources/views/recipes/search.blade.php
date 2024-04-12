@extends('layouts.app')

@section('content')

<div class="container">
    <!-- 【開始】おすすめレシピ -->
    <div id="service" class="section-padding">
            <div class="row">
                <div class="col-12">
                    <div class="intro-section text-center mb-4">

                        <h1 class="fw-bold">検索結果</h1>
                        <p class="mx-auto">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Dolorem quod alias veniam eveniet beatae facere inventore. Ab, facilis distinctio doloremque ullam, delectus libero illo illum corrupti, alias aliquam atque exercitationem?</p>
                    </div>
                </div>
            </div>

            <div class="row gy-1">
                {{-- 個数の分だけカードを表示させる --}}
                @foreach($recipes as $recipe)
                <div class="col-md-6 col-lg-3">
                    <div class="card mb-3 service">
                        {{-- カードデザイン --}}
                        <h4 class="card-header">{{ $recipe->title }}</h4>
                        
                        <!-- 星評価アイコン (上部) -->
                        <div class="star-rating text-end me-2">
                            @for ($i = 1; $i <= 5; $i++)
                                @if ($i <= $recipe->rating)
                                    <span class="bi bi-star-fill text-warning"></span>
                                @else
                                    <span class="bi bi-star text-warning"></span>
                                @endif
                            @endfor
                        </div>
            
                        {{-- 画像を配置 --}}
                        @if($recipe->image)
                            <img src="{{ asset('storage/recipe_images/' . basename($recipe->image)) }}" class="card-img-top rounded-0" alt="{{ $recipe->title }}">
                        @else
                            <img src="{{ asset('imgs/no-image.png') }}" class="card-img-top rounded-0" alt="{{ $recipe->title }}">
                        @endif
                        
                            <div class="card-footer text-center">
                                <a href="{{ route('recipes.detail', ['id' => $recipe->id]) }}" class="btn btn-warning">詳しく見る</a>
                                
                                @auth
                                @if(auth()->user()->id === $recipe->user_id)
                                    <button type="button" class="btn btn-secondary" data-bs-toggle="modal" data-bs-target="#myModal_{{ $recipe->id }}" style="margin-left: 10px;">編集する</button>
                                @endif
                                @endauth
                            </div>

                    </div>
                </div>
                @endforeach
            </div>
                                                                                                                                                
            {{-- モーダル --}}
            @foreach($recipes as $recipe)
            <div class="modal fade" id="myModal_{{ $recipe->id }}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">{{ $recipe->title }}</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <p>{{ $recipe->description }}</p>
                        </div>
                        <div class="modal-footer">
                            @auth
                            @if(auth()->user()->id === $recipe->user_id)
                                <a href="{{ route('recipes.edit', $recipe) }}" class="btn btn-primary">編集</a>
            
                                <form method="POST" action="{{ route('recipes.destroy', $recipe->id) }}" onsubmit="return confirm('本当にこのレシピを削除しますか？')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger d-block mx-auto my-3">削除</button>
                                </form>
                            @endif
                            @endauth
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
            {{-- モーダル --}}
                </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // 削除ボタンをクリックしたときに確認メッセージを表示
        document.querySelectorAll('.btn-delete').forEach(function(button) {
            button.addEventListener('click', function(e) {
                if (!confirm('本当に削除しますか？')) {
                    e.preventDefault(); // 削除ボタンのデフォルトの動作をキャンセル
                }
            });
        });
    });

</script>

@endsection
