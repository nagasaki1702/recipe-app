@extends('layouts.app')

@section('content')
<div class="container section-padding">
    
    <h2>レシピを更新する</h2>
    <div class="row flex-column-reverse flex-md-row">
        <div class="col-md-7">
            <form method="POST" action="{{ route('recipes.update', $recipe->id) }}" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="form-group my-1">
                    <label for="title">タイトル</label>
                    <input type="text" name="title" id="title" class="form-control" required value="{{ $recipe->title }}">
                    @error('title')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group my-1">
                    <label for="description">説明</label>
                    <textarea name="description" id="description" class="form-control" rows="10" required>{{ $recipe->description }}</textarea>
                    @error('description')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group custom-form">
                    <label for="formFile" class="form-label my-1">画像・写真を載せる</label>
                    <input class="form-control mt-1 mb-4" type="file" id="formFile" accept="image/*" name="image">
                    @error('image')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>

                <!-- 材料の入力フォーム -->
                <div id="ingredient-form-container">
                    <label for="ingredient" class="form-label my-1">材料</label>
                    <button type="button" id="add-ingredient-field" class="btn btn-outline-primary btn-sm mb-2"> ＋ </button>

                    @foreach ($recipe->ingredients as $index => $ingredient)
                        <div class="form-row mb-2 ingredient-form">
                            <input type="text" name="ingredients[{{ $index }}][name]" class="form-control custom-input" placeholder="材料" value="{{ $ingredient['name'] }}">
                            <input type="text" name="ingredients[{{ $index }}][quantity]" class="form-control custom-input" placeholder="量" value="{{ $ingredient['quantity'] }}">
                            <input type="text" name="ingredients[{{ $index }}][unit]" class="form-control custom-input" placeholder="単位" value="{{ $ingredient['unit'] }}">
                        </div>
                    @endforeach
                </div>


                <div class="text-center" style="width: 100%;">
                    <button type="submit" class="btn btn-primary mt-3">　更 新　</button>
                </div>
            </form>
        </div>

        <div class="col-md-5">
            <!-- 現在の画像 -->
            @if($recipe->image)
                <div class="form-group mb-3 text-center">
                <label style="font-size: 24px; margin-bottom: 3px; text-align: left;" class="my-3">現在登録されている画像・写真</label>
                <img src="{{ asset('storage/recipe_images/' . basename($recipe->image)) }}" alt="" class="img-thumbnail mx-auto" style="width: 20rem; height: 20rem; display: block;">
            @else
                <img src="{{ asset('imgs/no-image.png') }}" alt="デフォルト画像" class="img-thumbnail mx-auto" style="width: 400px; height: 400px; display: block;">
            @endif        
                </div>

        </div>
    </div>
</div>

<script>
    let ingredientCount = {{ count($recipe->ingredients) }};
    const container = document.getElementById('ingredient-form-container');
    const addButton = document.getElementById('add-ingredient-field');

    addButton.addEventListener('click', () => {
        const newForm = document.createElement('div');
        newForm.classList.add('form-row', 'mb-2', 'ingredient-form');
        newForm.innerHTML = `
            <input type="text" name="ingredients[${ingredientCount}][name]" class="form-control custom-input" placeholder="材料">
            <input type="text" name="ingredients[${ingredientCount}][quantity]" class="form-control custom-input" placeholder="量">
            <input type="text" name="ingredients[${ingredientCount}][unit]" class="form-control custom-input" placeholder="単位">
        `;
        container.appendChild(newForm);
        ingredientCount++;
    });
</script>
@endsection

