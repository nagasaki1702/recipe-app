<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Storage; // Storage クラスを使用するために追加
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

use Illuminate\Support\Facades\Validator;


// モデルをインポート
use App\Models\User; 
use App\Models\Recipe;
use App\Models\Ingredient;
use App\Models\Comment;
use App\Models\Keyword;
use App\Models\RecipeRating;


class RecipeRatingController extends Controller
{


// 星評価の平均値を求める
    public function calculateAverageRating($recipeId)
    {
        // IDを使用してレシピを検索
        $recipe = Recipe::findOrFail($recipeId);

        // レシピに関連するすべての評価を取得
        $ratings = RecipeRating::where('recipe_id', $recipe->id)->pluck('rating');

        if ($ratings->isEmpty()) {
            $averageRating = 0; // 評価がない場合、デフォルトで0に設定
        } else {
            $averageRating = $ratings->avg(); // 平均評価を計算
        }

        return view('recipes.average_rating', [
            'recipe' => $recipe,
            'averageRating' => $averageRating,
        ]);
    }

}
