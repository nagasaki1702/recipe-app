@extends('layouts.app')

@section('content')
<div class="container">
    <div id="service" class="section-padding">
        <div class="row">
            <div class="col-12">
                <div class="intro-section text-center mb-4">
                    <h1 class="fw-bold text-center">検索結果</h1>
                    
                    <!-- 一覧に戻るボタンを追加 -->
                    <a href="{{ route('ingredients.index') }}" class="btn btn-primary">一覧に戻る</a>

                </div>
                <table class="table table-striped text-center">
                    <thead>
                        <tr>
                            <th>レシピ名</th>
                            <th>材料</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($recipes as $recipe)
                        @if (!$recipe->ingredients->isEmpty()) <!-- Check if recipe has ingredients -->
                            <tr>
                                <td>{{ $recipe->title }}</td>
                                <td>
                                    <ul class="list-unstyled">
                                        @foreach ($recipe->ingredients as $ingredient)
                                            <li class="d-inline">{{ $ingredient->name }}</li>
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
@endsection
