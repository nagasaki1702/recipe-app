@extends('layouts.app')

@section('content')
<div class="container">
    <div id="service" class="section-padding">
        <div class="row">
            <div class="col-12">
                <div class="intro-section text-center mb-4">
                    <h1 class="fw-bold text-center">トップ画面：バッジ編集</h1>
                    <p class="mx-auto text-center">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Dolorem quod alias veniam eveniet beatae facere inventore. Ab, facilis distinctio doloremque ullam, delectus libero illo illum corrupti, alias aliquam atque exercitationem?</p>

                    {{-- 材料のキーワード登録フォーム --}}
                    <div class="col-md-12">
                        <h5 class="d-flex mx-3 mt-2">バッジ編集:</h5>
                        <form action="{{ route('keywords.update', ['id' => $keywords[0]->id]) }}" method="POST" class="my-3">
                            @csrf
                            @method('PATCH') {{-- 修正 --}}                        
                            {{-- 材料名の編集フォーム --}}
                            {{-- 材料名の入力フォーム --}}
                            <div class="row mt-1 justify-content-center">
                                @for ($i = 1; $i <= 5; $i++)
                                    <div class="col-md-2">
                                        <div class="form-group my-1">
                                            <label for="ingredient{{ $i }}">材料名{{ $i }}</label>
                                            <input type="text" name="ingredient_{{ $i }}" id="ingredient{{ $i }}" class="form-control" required value="{{ old("ingredient_{$i}", isset($keywords[$i-1]) ? $keywords[$i-1]->name : '') }}">
                                            
                                            @error("ingredient_{$i}")
                                                <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                @endfor
                            </div>

                            {{-- 材料名の入力フォーム --}}
                            <div class="row mt-1 justify-content-center">
                                @for ($i = 6; $i <= 10; $i++)
                                    <div class="col-md-2">
                                        <div class="form-group my-1">
                                            <label for="ingredient{{ $i }}">材料名{{ $i }}</label>
                                            <input type="text" name="ingredient_{{ $i }}" id="ingredient{{ $i }}" class="form-control" required value="{{ old("ingredient_{$i}", isset($keywords[$i-1]) ? $keywords[$i-1]->name : '') }}">
                                            @error("ingredient_{$i}")
                                                <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                @endfor
                            </div>
                        
                            {{-- 編集ボタン --}}
                            <div class="row mb-5 justify-content-center">
                                <div class="col-md-3 mt-3">
                                    <button type="submit" class="btn btn-primary mt-3"> 編 集 </button>
                                </div>
                            </div>
                        </form>
                                                
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
