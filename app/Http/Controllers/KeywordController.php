<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
// モデルをインポート
use App\Models\User; 
use App\Models\Recipe;
use App\Models\Ingredient;
use App\Models\Comment;
use App\Models\Keyword;
use App\Models\RecipeRating;
use Illuminate\Support\Facades\Log;



class KeywordController extends Controller
{
// 一覧を表示するのはIngredientControllerなので、KeywordControllerにその機能はない。
// キーワードと材料がちょっと意味合いがかぶっているからいけなかったなー。


// 材料名をバッジ登録をする動き
    public function register(Request $request)
    {
        // バリデーションルールを設定
        $validationRules = [];
        $ingredients = [];

        for ($i = 1; $i <= 10; $i++) {
            $ingredientFieldName = "ingredient{$i}";
            $validationRules[$ingredientFieldName] = 'nullable';

            // リクエストから各材料を取得
            $ingredients[$i - 1] = $request->input($ingredientFieldName);
        }

        $this->validate($request, $validationRules);

        // キーワードをデータベースに登録
        foreach ($ingredients as $ingredient) {
            if (!empty($ingredient)) {
                Keyword::create([
                    'name' => $ingredient,
                    'role' => 1, // デフォルトで1を設定
                    'user_id' => 1, // ユーザーIDを1に設定(これは後に管理者に設定するため)
                ]);
            }
        }

        // 成功メッセージを含めてリダイレクト
        return redirect()->route('ingredients.index')->with('success', 'キーワードを登録しました！');
    }



    public function editKeyword()
    {
        // 編集対象のキーワードを取得
        $keywords = Keyword::take(10)->get();
        
        // 編集画面を表示(ここでは、ingredientsという名前のディレクトリに入っている、edit.blade.phpを見せてくれるという意味。＊ここはルート名じゃない！)
        return view('ingredients.edit', compact('keywords'));
    }



    public function updateKeyword(Request $request, $id)
    {
        // キーワードを取得
        $keywords = Keyword::all(); // 仮のコード。必要に応じて実際の取得方法に修正してください。

        // キーワードが存在しない場合はリダイレクトなどの処理
        if (!$keywords) {
            return back()->with('error', '指定されたキーワードが見つかりませんでした。');
        }

        // バリデーションが必要であれば追加
        $request->validate([
            // ここに適切なバリデーションルールを追加
            
        ]);

        // キーワードを更新
        foreach ($keywords as $keyword) {
            $keyword->update([
                'name' => $request->input("ingredient_{$keyword->id}"),
                // 他の更新したいフィールドがあればここに追加
            ]);
        }

        // 更新が成功したらリダイレクトなどの処理
        return back()->with('success', 'キーワードが更新されました。');
    }
    
    
    
    
    // ホーム画面から材料名バッジを押下した場合に、「その材料名を含むレシピを表示する画面」を表示する動き
    public function show($id)
    {
        // 材料名キーワードを使って材料テーブルから曖昧検索
        $keyword = Keyword::find($id);
        $ingredients = Ingredient::where('name', 'like', '%' . $keyword->name . '%')->get();
    
        // 材料名が見つからない場合の処理
        if ($ingredients->isEmpty()) {
            return view('keywords.index', ['relatedRecipes' => collect(), 'averageRatings' => [], 'recipes' => collect(), 'keyword' => $keyword]);
        }
    

        $relatedRecipes = Recipe::whereHas('ingredients', function ($query) use ($ingredients) {
            $query->whereIn('name', $ingredients->pluck('name')->toArray());
        })->get();
    
        // 各レシピの平均評価を計算して配列に格納
        $averageRatings = [];
    
        if ($relatedRecipes) {
            foreach ($relatedRecipes as $recipe) {
                $ratings = RecipeRating::where('recipe_id', $recipe->id)->pluck('rating');
                if ($ratings->isEmpty()) {
                    $averageRating = 0;
                } else {
                    $averageRating = $ratings->avg();
                }
                $averageRatings[$recipe->id] = $averageRating;
            }
        }
    
        // モーダルで使用するための全てのレシピを取得
        $recipes = Recipe::all();
    
        return view('keywords.index', compact('relatedRecipes', 'averageRatings', 'recipes', 'keyword'));
    }    


}
