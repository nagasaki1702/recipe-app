<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Storage; // Storage クラスを使用するために追加
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;


use Illuminate\Support\Facades\Validator;


// モデルをインポート
use App\Models\User; 
use App\Models\Recipe;
use App\Models\Ingredient;
use App\Models\Comment;
use App\Models\Keyword;
use App\Models\RecipeRating;





class RecipeController extends Controller {

// 【create】投稿画面を表示する
    public function create()
    {
        // ランダムでパスを取得して表示させる。押下するとレシピ画面へ遷移する（レシピ詳細画面を作成していない・・）
        $randomImage = Recipe::inRandomOrder()->first(); // ランダムなデータを1つ取得
        return view('recipes.create', compact('randomImage'));
    }


// 【index】投稿されたレシピを一覧表示する
    public function index()
    {
        $recipes = Recipe::all(); // Recipeモデルを使用してデータを取得

        $recipes = Recipe::paginate(12); // 1ページあたりのアイテム数を指定します

        // 各レシピの平均評価を計算して配列に格納
        $averageRatings = [];

        foreach ($recipes as $recipe) {
            $ratings = RecipeRating::where('recipe_id', $recipe->id)->pluck('rating');
            if ($ratings->isEmpty()) {
                $averageRating = 0;
            } else {
                $averageRating = $ratings->avg();
            }
            $averageRatings[$recipe->id] = $averageRating;
        }

        return view('recipes.index', compact('recipes', 'averageRatings'));
    }


// 星の評価ごとに表示させる
    public function ratedIndex($desiredStar)
    {
        $recipes = Recipe::all(); // Recipeモデルを使用してデータを取得

        // 各レシピの平均評価を計算して配列に格納
        $averageRatings = [];
        
        foreach ($recipes as $recipe) {
            $ratings = RecipeRating::where('recipe_id', $recipe->id)->pluck('rating');
            if ($ratings->isEmpty()) {
                $averageRating = 0;
            } else {
                $averageRating = $ratings->avg();
            }
            $averageRatings[$recipe->id] = $averageRating;
        }
        
        // ページネーションなしでデータを取得
        $recipes = collect($recipes);
        
        // レシピを選択
        $filteredRecipes = $recipes->filter(function ($recipe) use ($desiredStar, $averageRatings) {
            return $averageRatings[$recipe->id] == $desiredStar;
        });
        
        // ページ番号をユーザーが指定したものにセットする
        $currentPage = request()->input('page', 1);

        // ページネーションを再設定
        $recipes = new LengthAwarePaginator(
            $filteredRecipes->forPage($currentPage, 12),
            $filteredRecipes->count(),
            12,
            $currentPage,
            ['path' => route('recipes.ratedIndex', ['desiredStar' => $desiredStar])]
        );

        return view('recipes.rated', compact('recipes', 'averageRatings', 'desiredStar'));
    }        


// 【store】投稿フォームに入力された値をデータベースに入れる
    public function store(Request $request)
    {
        // 現在の認証ユーザーのIDを取得
        $userId = auth()->user()->id;

        // フォームから送信されたデータを取得
        $data = $request->validate([
            'title' => 'required|string',
            'description' => 'required|string',
            'image' => 'image|mimes:jpeg,png,jpg,gif|max:2048', // 画像のバリデーションルール
            'ingredients' => 'array', // 材料データが配列であることを確認
            'ingredients.*.name' => 'nullable|string|max:255', // 材料名はnullable（空でもOK）
            'ingredients.*.quantity' => 'nullable|string|max:255', // 量はnullable（空でもOK）
            'ingredients.*.unit' => 'nullable|string|max:255', // 単位はnullable（空でもOK）
        ]);

        $imagePath = null; // 初期化

        // ファイルがアップロードされているかを確認
        if ($request->hasFile('image')) {
            // 画像を保存し、保存パスを取得
            $imagePath = $request->file('image')->store('public/recipe_images');
            $data['image'] = $imagePath;
        }

        // レシピを作成し、ユーザーIDを設定して保存
        $recipe = new Recipe($data);
        $recipe->user_id = $userId;

        if (!is_null($imagePath)) {
            $recipe->image = $imagePath;
        }

        $recipe->save();

        // 材料情報を保存
        if (!empty($data['ingredients'])) {
            foreach ($data['ingredients'] as $ingredientData) {
                if (!empty($ingredientData['name'])) {
                    $ingredient = new Ingredient();
                    $ingredient->name = $ingredientData['name'];
                    $ingredient->quantity = $ingredientData['quantity'];
                    $ingredient->unit = $ingredientData['unit'];
                    $ingredient->recipe_id = $recipe->id;
                    $ingredient->save();
                }
            }
        }

        // レシピが正常に保存された場合のリダイレクトなどの処理を行う
        return redirect()->route('recipes.index')->with('success', 'レシピが登録されました');
    }


// 【edit】編集するボタンを押下したら、編集画面を表示させる
    public function edit(Recipe $recipe)
    {
        $ingredients = $recipe->ingredients; // レシピに関連する材料情報を取得

        return view('recipes.edit', compact('recipe', 'ingredients'));
    }


// 更新ボタンを押下したら、情報をアップデートして一覧画面に戻る
    public function update(Request $request, $id)
    {
        // データベーストランザクションの開始
        DB::beginTransaction();

        try {
            $recipe = Recipe::find($id);

            if (!$recipe) {
                // レシピが見つからない場合、エラーメッセージを表示してリダイレクト
                return redirect()->route('recipes.index')->with('error', 'レシピが見つかりません。');
            }

            $request->validate([
                'title' => 'required',
                'description' => 'required',
                'image' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
            ]);

            $recipe->title = $request->input('title');
            $recipe->description = $request->input('description');

            if ($request->hasFile('image')) {
                // 画像がアップロードされた場合
                $image = $request->file('image');
                $imageName = time() . '.' . $image->getClientOriginalExtension();
                $image->storeAs('public/recipe_images', $imageName);

                // 旧画像を削除
                if ($recipe->image) {
                    $oldImage = 'public/recipe_images/' . $recipe->image;
                    if (Storage::exists($oldImage)) {
                        Storage::delete($oldImage);
                    }
                }

                $recipe->image = $imageName;
            }

            $recipe->save();

            // 材料情報の削除と再登録
            $recipe->ingredients()->delete();

            if ($request->has('ingredients')) {
                $ingredientsData = $request->input('ingredients');

                foreach ($ingredientsData as $ingredientData) {
                    // バリデーションルールを定義
                    $rules = [
                        'name' => 'required|string|max:255',
                        'quantity' => 'required|string|max:255',
                        'unit' => 'required|string|max:255',
                    ];

                    $validator = Validator::make($ingredientData, $rules);

                    if ($validator->fails()) {
                        // バリデーションエラーがある場合、トランザクションをロールバックしてエラーメッセージを表示してリダイレクト
                        DB::rollBack();
                        return redirect()->route('recipes.index')->with('error', '材料情報のバリデーションエラーが発生しました。')->withErrors($validator)->withInput();
                    }

                    $ingredient = new Ingredient();
                    $ingredient->name = $ingredientData['name'];
                    $ingredient->quantity = $ingredientData['quantity'];
                    $ingredient->unit = $ingredientData['unit'];
                    $ingredient->recipe_id = $recipe->id;

                    $ingredient->save();
                }
            }

            // すべての処理が成功した場合、トランザクションをコミットしてリダイレクト
            DB::commit();
            return redirect()->route('recipes.index')->with('success', 'レシピが更新されました.');
        } catch (\Exception $e) {
            // エラーが発生した場合、トランザクションをロールバックしてエラーメッセージを表示してリダイレクト
            DB::rollBack();
            return redirect()->route('recipes.index')->with('error', 'レシピの更新中にエラーが発生しました.');
        }
    }


// 検索機能
    public function search(Request $request)
    {
        $query = $request->input('query');
        
        $recipes = Recipe::where('title', 'like', "%$query%")
                        ->orWhere('description', 'like', "%$query%")
                        ->get();

        return view('recipes.search', ['recipes' => $recipes, 'query' => $query]);
    }


// 削除ボタンを押下したら、削除されて一覧画面に戻る
    public function destroy($id)
    {
        // 指定された ID のレシピを取得
        $recipe = Recipe::find($id);

        if (!$recipe) {
            // レシピが見つからない場合のエラーハンドリング
            return redirect()->route('recipes.index')->with('error', '指定されたレシピが見つかりませんでした。');
        }

        // レシピを削除
        $recipe->delete();

        // 削除が成功した場合のリダイレクト
        return redirect()->route('recipes.index')->with('success', 'レシピが削除されました。');
    }


// 星評価の平均点も合わせて一覧表を表示する
    public function detailShow($id)
    {
        // レシピデータを取得
        $recipe = Recipe::with('ingredients')->find($id);

        // 他の必要なデータを取得
        $comments = Comment::where('recipe_id', $id)->get();

        // ユーザーの評価データを取得
        $userRating = RecipeRating::where('recipe_id', $id)
            ->where('user_id', Auth::id())
            ->first();

        return view('recipes.detail', [
            'recipe' => $recipe,
            'comments' => $comments,
            'userRating' => $userRating, // 評価データをビューに渡す
        ]);
    }



// 星評価データを保存するアクション
    public function rateRecipe(Request $request)
    {
        // フォームデータのバリデーション
        $request->validate([
            'selected-rating' => 'required|integer|min:1|max:5', // 1から5までの整数を期待
            'recipeId' => 'required|exists:recipes,id', // recipeIdが存在するレシピのIDであることを確認
        ]);

        // 認証済みユーザーのIDを取得
        $userId = Auth::id();

        // フォームから送信された評価データを取得
        $selectedRating = $request->input('selected-rating');
        $recipeId = $request->input('recipeId');

        // 既存の評価を取得
        $existingRating = RecipeRating::where('recipe_id', $recipeId)
            ->where('user_id', $userId)
            ->first(); // 最初の評価を取得

        if ($existingRating) {
            // 既存の評価がある場合は更新
            $existingRating->rating = $selectedRating;
            // 他の必要なフィールドをここで設定
            $existingRating->save();
        } else {
            // 既存の評価がない場合は新しい評価を作成
            $rating = new RecipeRating;
            $rating->recipe_id = $recipeId;
            $rating->user_id = $userId;
            $rating->rating = $selectedRating;
            // 他の必要なフィールドをここで設定
            $rating->save();
        }

        // 評価情報をデータベースに正しく保存できるようにする

        // コントローラー内で $recipe 変数を取得
        $recipe = Recipe::find($recipeId);

        // コントローラー内で $comments 変数を取得
        $comments = Comment::where('recipe_id', $recipe->id)->get();

        // コントローラー内で評価データを再度取得
        $userRating = RecipeRating::where('recipe_id', $recipeId)
            ->where('user_id', $userId)
            ->first();

        return view('recipes.detail', [
            'recipe' => $recipe,
            'comments' => $comments,
            'userRating' => $userRating, // 評価データをビューに渡す
        ]);
    }


// レシピにどれだけの材料が登録されているか一覧表示する（バッジ製作の準備画面）（管理者だけが見れるように後ほど設定する）
    public function ingredientIndex()
    {
        $recipes = Recipe::with('ingredients')->get();
        $ingredients = Ingredient::all(); // 材料データを取得

        return view('ingredients.index', compact('recipes', 'ingredients'));
    }


// ホーム画面において、レシピに登録されている材料名が表示されたバッジを押下すると、その材料が使われているレシピ一覧を表示させる動き
// TODO:バッジ押下後の一覧画面も作成する必要あり！！
    public function showRecipesByIngredient($ingredientName)
    {
        // 特定の材料名に関連するレシピを取得
        $recipes = Recipe::whereHas('ingredients', function ($query) use ($ingredientName) {
            $query->where('name', $ingredientName);
        })->get();

        return view('recipes.index', compact('recipes'));
    }


}
