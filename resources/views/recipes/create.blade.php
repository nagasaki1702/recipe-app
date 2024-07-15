@extends('layouts.app')

@section('content')
<div class="container section-padding">
    <h2>レシピを投稿する</h2>
    <div class="row flex-md-row">
        <div class="col-md-7">
            <form method="POST" action="{{ route('recipes.store') }}" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="user_id" value="{{ auth()->user()->id }}">
                <div class="form-group my-1">
                    <label for="title">タイトル</label>
                    <input type="text" name="title" id="title" class="form-control" required value="{{ old('title') }}">
                    @error('title')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>


                <div class="form-group my-1">
                    <label for="description">説明</label>
                    <textarea name="description" id="description" class="form-control" rows="10" required>{{ old('description') }}</textarea>
                    @error('description')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>
                <div class="form-group custom-form">
                    <label for="formFile" class="form-label my-1">画像・写真を載せる</label>
                    <input class="form-control mt-1 mb-4" type="file" id="formFile" accept="image/*" name="image">
                </div>
                
                <!-- 材料の入力フォーム -->
                <div id="ingredient-form-container">
                    <div class="form-group ingredient-form">
                        <label for="ingredient" class="form-label my-1">材料</label>
                        <button type="button" id="add-ingredient-field" class="btn btn-outline-primary btn-sm mb-2"> ＋ </button>
                        <div class="form-row mb-2">
                            <input type="text" name="ingredients[0][name]" class="form-control custom-input" placeholder="材料">
                            <input type="text" name="ingredients[0][quantity]" class="form-control custom-input" placeholder="量">
                            <input type="text" name="ingredients[0][unit]" class="form-control custom-input" placeholder="単位">
                        </div>
                    </div>
                </div>
                <div class="text-center" style="width: 100%;">
                    <button type="submit" class="btn btn-primary mt-3">登 録</button>
                </div>
            </form>
        </div>
        
        <div class="col-md-5">
            @if ($randomImage)
                <div class="form-group mb-3 text-center">
                    <label style="font-size: 24px; margin-bottom: 3px; text-align: left;" class="my-3">あなたにおすすめのレシピ</label>
                    <img src="{{ asset('storage/recipe_images/' . basename($randomImage->image)) }}" alt="" class="img-thumbnail mx-auto" style="width: 20rem; height: 20rem; display: block;">
                </div>
            @else
                <img src="{{ asset('public/imgs/no-image.png') }}" alt="デフォルト画像" class="img-thumbnail mx-auto" style="width: 400px; height: 400px; display: block;">
            @endif        
        </div>
    </div>
</div>

<script>
    let ingredientCount = 1;
    const container = document.getElementById('ingredient-form-container');
    const addButton = document.getElementById('add-ingredient-field');

    addButton.addEventListener('click', () => {
        const newForm = document.createElement('div');
        newForm.classList.add('form-group', 'ingredient-form');
        newForm.innerHTML = `
        <div class="form-row mb-2">
            <input type="text" name="ingredients[${ingredientCount}][name]" class="form-control custom-input" placeholder="材料">
            <input type="text" name="ingredients[${ingredientCount}][quantity]" class="form-control custom-input" placeholder="量">
            <input type="text" name="ingredients[${ingredientCount}][unit]" class="form-control custom-input" placeholder="単位">
        </div>
        `;
        container.appendChild(newForm);
        ingredientCount++;
    });
</script>
@endsection
