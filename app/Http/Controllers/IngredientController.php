<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;

// モデルをインポート
use App\Models\User; 
use App\Models\Recipe;
use App\Models\Ingredient;
use App\Models\Comment;
use App\Models\Keyword;
use App\Models\RecipeRating;


class IngredientController extends Controller
{



    // レシピ登録画面からの、材料の登録
    public function store(Request $request)
    {
        $request->validate([
            'ingredients.*.name' => 'required|string|max:255',
            'ingredients.*.quantity' => 'required|string|max:255',
            'ingredients.*.unit' => 'required|string|max:255',
        ]);

        foreach ($request->input('ingredients') as $ingredientData) {
            Ingredient::create([
                'name' => $ingredientData['name'],
                'quantity' => $ingredientData['quantity'],
                'unit' => $ingredientData['unit'],
            ]);
        }

        return redirect()->route('recipes.index');
    }



// 材料名の一覧表示（これはキーワード登録する画面の一部となっている）
    public function index()
    {
        $recipes = Recipe::with('ingredients')->get();
        $ingredients = Ingredient::all();
        $ingredientName = ''; // ここで初期化

        return view('ingredients.index', compact('recipes', 'ingredients', 'ingredientName'));
    }



    // 材料名から検索する
    public function search(Request $request)
    {
        $ingredientName = $request->input('ingredientName');

        // 材料名を使って検索処理を行う
        $recipes = Recipe::whereHas('ingredients', function ($query) use ($ingredientName) {
            $query->where('name', 'like', "%$ingredientName%");
        })->get();

        return view('ingredients.search', compact('recipes', 'ingredientName'));
    }

}
