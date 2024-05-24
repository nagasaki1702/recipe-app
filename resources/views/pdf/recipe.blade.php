<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Recipe PDF</title>
    <style>
        .recipe-info {
            text-align: center;
            margin-bottom: 20px;
        }
        .recipe-info img {
            max-width: 100%;
            height: auto;
        }
        /* dompdf日本語文字化け対策 */
        /* フォントをみんなipagに設定しておかないと日本語にならない・・ */
        @font-face {
            font-family: 'ipag';
            font-style: normal;
            font-weight: normal;
            src: url('{{ storage_path('fonts/ipag.ttf') }}') format('truetype');
        }
        @font-face {
            font-family: 'ipag';
            font-style: bold;
            font-weight: bold;
            src: url('{{ storage_path('fonts/ipag.ttf') }}') format('truetype');
        }
        body {
            font-family: 'ipag', 'Arial', sans-serif;
        }
        html, body, textarea {
            font-family: 'ipag', 'Arial', sans-serif;
        }
    </style>
</head>

<body>
    <div class="recipe-info">
        <h1>{{ $recipe->title }}</h1>
        @if ($recipe->image)
            <img src="{{ public_path('storage/recipe_images/' . basename($recipe->image)) }}" alt="{{ $recipe->title }}" class="img-thumbnail" style="width: 22rem;">
        @else
        <!-- 画像が存在しない場合は、代替の「noimage」画像を表示 -->
            <img src="{{ public_path('imgs/no-image.png') }}" alt="No Image" class="img-thumbnail" style="width: 22rem;">
        @endif

        <div>{{ $recipe->description }}</div>


        {{-- <div>これは日本語のテキストです。</div> --}}
        <div class="ingredients">
            <h2>材料:</h2>
            <div>
                @foreach($recipe->ingredients as $ingredient)
                    <div>{{ $ingredient }}</div>
                @endforeach
            </div>
        </div>

    </div>
</body>
</html>
