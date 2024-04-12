@extends('layouts.app')

@section('content')
<div class="container">
    <div id="service" class="section-padding">
        <div class="row">
            <div class="col-12">
                <div class="intro-section text-center mb-4">
                    <h1 class="fw-bold text-center">レシピ・材料一覧</h1>
                    <p class="mx-auto text-center">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Dolorem quod alias veniam eveniet beatae facere inventore. Ab, facilis distinctio doloremque ullam, delectus libero illo illum corrupti, alias aliquam atque exercitationem?</p>

                    <form action="{{ route('ingredients.search') }}" method="GET" class="my-3">
                        <div class="row align-items-center justify-content-center">
                            <div class="col-12 col-md-5 mt-3">
                                <input type="text" name="ingredientName" class="form-control" placeholder="材料名を入力" value="{{ $ingredientName }}">
                            </div>
                            <div class="col-2 col-md-1 px-1 mt-3"> 
                                <button type="submit" class="btn btn-primary text-nowrap">検索</button>
                            </div>
                            <div class="col-2 col-md-1 px-1 mt-3">
                                <button type="reset" class="btn btn-secondary text-nowrap">リセット</button>
                            </div>
                        </div>
                    </form>
                    
                    {{-- 材料のキーワード参照 --}}
                    <div id="selected-ingredients" class="d-flex mt-5">
                        <h5 class="mx-3">バッジ登録候補:</h2>
                        <ul class="d-flex" style="list-style-type: none; padding: 0;"></ul>
                    </div>

                    {{-- 材料のキーワード登録フォーム --}}
                    <div class="col-md-12">
                        <h5 class="d-flex mx-3 mt-2">バッジ登録:</h5>
                        <form action="{{ route('keywords.register') }}" method="POST" class="my-3">
                            @csrf

                            {{-- 材料名の入力フォーム --}}
                            <div class="row mt-1 justify-content-center">
                                @for ($i = 1; $i <= 5; $i++)
                                    <div class="col-md-2">
                                        <div class="form-group my-1">
                                            <label for="ingredient{{ $i }}">材料名{{ $i }}</label>
                                            <input type="text" name="ingredient{{ $i }}" id="ingredient{{ $i }}" class="form-control" required value="{{ old("ingredient{$i}") }}">
                                            @error("ingredient{$i}")
                                                <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                @endfor
                            </div>

                            <div class="row mt-1 justify-content-center">
                                @for ($i = 6; $i <= 10; $i++)
                                    <div class="col-md-2">
                                        <div class="form-group my-1">
                                            <label for="ingredient{{ $i }}">材料名{{ $i }}</label>
                                            <input type="text" name="ingredient{{ $i }}" id="ingredient{{ $i }}" class="form-control" required value="{{ old("ingredient{$i}") }}">
                                            @error("ingredient{$i}")
                                                <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                @endfor
                            </div>
                        {{-- 登録ボタン --}}
                            <div class="row mb-5 justify-content-center">
                                <div class="col-md-3 mt-3">
                                    <button type="submit" class="btn btn-primary mt-3"> 登 録 </button>
                                </div>
                            </div>
                        </form>
                    </div>

                    {{-- ざっくり材料の一覧が表示される部分 --}}
                    <div class="overflow-auto" style="max-height: 400px;">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>レシピ名</th>
                                    <th>材料</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($recipes as $recipe)
                                    @if (!$recipe->ingredients->isEmpty())
                                        <tr>
                                            <td>{{ $recipe->title }}</td>
                                            <td>
                                                <ul class="list-unstyled">
                                                    @foreach ($recipe->ingredients as $ingredient)
                                                        <li class="form-check form-check-inline">
                                                            <label class="form-check-label">
                                                                {{ $ingredient->name }}
                                                            </label>
                                                            <input type="checkbox" class="form-check-input" id="ingredient-{{ $loop->index }}" value="{{ $ingredient->name }}">
                                                        </li>
                                                    @endforeach
                                                </ul>
                                            </td>
                                        </tr>
                                    @endif
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Custom Alert -->
<div id="custom-alert" class="custom-alert">
    <div class="custom-alert-content">
        <p>選択できるのは10個までです。</p>
        <button id="custom-alert-close" class="btn btn-warning">閉じる</button>
    </div>
</div>

<style>
    /* Add your custom styles here */
    .custom-alert {
        display: none;
        position: fixed;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        background-color: #ffffff;
        box-shadow: 0px 0px 5px rgba(0, 0, 0, 0.2);
        padding: 20px;
        z-index: 9999;
    }

    .custom-alert-content {
        text-align: center;
    }

    #custom-alert-close {
        background-color: #e95420;
        color: #fff;
        border: none;
        padding: 5px 10px;
        cursor: pointer;
    }

    /* 番号の後ろに空白を追加 */
    ul.d-flex li::before {
        content: "\00a0\00a0"; /* 空白を追加（\00a0 はノーブレークスペース） */
    }
</style>

<script>
    // Custom JavaScript
</script>
@endsection
