<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

use App\Models\Video;

use App\Http\Controllers\UserController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\RecipeController;
use App\Http\Controllers\IngredientController;
use App\Http\Controllers\KeywordController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\VideoController;
use App\Http\Controllers\PdfController;
use App\Http\Controllers\RecipeRatingController;


use Barryvdh\DomPDF\Facade as PDF;




/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    // return view('welcome');
    return view('auth.login');

});

Auth::routes();


Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::middleware(['auth'])->group(function () {
    // ホーム
    Route::get('/home', [HomeController::class, 'index'])->name('home');

    // レシピ関連
    Route::prefix('/recipes')->group(function () {
        Route::get('/', [RecipeController::class, 'index'])->name('recipes.index');
        Route::get('/rated/{desiredStar}', [RecipeController::class, 'ratedIndex'])->name('recipes.ratedIndex');
        Route::post('/', [RecipeController::class, 'store'])->name('recipes.store');
        Route::get('/create', [RecipeController::class, 'create'])->name('recipes.create');
        Route::get('/{recipe}/edit', [RecipeController::class, 'edit'])->name('recipes.edit');
        Route::put('/{id}', [RecipeController::class, 'update'])->name('recipes.update');
        Route::delete('/{id}', [RecipeController::class, 'destroy'])->name('recipes.destroy');
        Route::get('/detail/{id}', [RecipeController::class, 'detailShow'])->name('recipes.detail');
        Route::post('/{recipeId}/rate', [RecipeController::class, 'rateRecipe'])->name('recipe.rate');
        Route::get('/{recipe}/average-rating', [RecipeRatingController::class, 'calculateAverageRating'])->name('recipe.average-rating');
        Route::get('/search', [RecipeController::class, 'search'])->name('recipes.search');
        
        // PDFで印刷画面出す
        Route::get('/{recipeId}/pdf', [PdfController::class, 'generatePDF'])->name('recipe.pdf');
        Route::get('/{recipeId}/download-pdf', [PdfController::class, 'generatePDF'])->name('recipe.download-pdf');
    });


    // 材料一覧画面の表示（これはバッジ登録画面にも関連する）
    Route::get('/ingredients', [IngredientController::class, 'index'])->name('ingredients.index');
    // キーワードを登録する動き
    Route::post('/ingredients', [KeywordController::class, 'register'])->name('keywords.register');
    // 材料検索後の画面表示（これはバッジ登録画面にも関連する）
    Route::get('/ingredients/search', [IngredientController::class, 'search'])->name('ingredients.search');

    // キーワードと材料が混同してわかりづらい画面になっている・・・反省！
    // TODO:キーワード編集画面を表示するだけルート
    Route::get('/ingredients/edit', [KeywordController::class, 'editKeyword'])->name('keywords.edit');

    // TODO:材料キーワードを更新するためのルート
    // Route::patch('/ingredients/{id}', [KeywordController::class, 'updateKeyword'])->name('keywords.update');
    Route::patch('/keywords/{id}', [KeywordController::class, 'updateKeyword'])->name('keywords.update');




// ホーム画面の材料名（バッジ登録された材料）をクリックした後に、当該材料名が登録されたレシピの一覧を表示する動き。一覧表示。indexでは名前が重複するようでうまくいかなかった。
    Route::get('/keywords/{id}', [KeywordController::class, 'show'])->name('keywords.show');

    
    // 動画関連
    Route::get('/videos/up', [VideoController::class, 'up'])->name('videos.up');
    Route::post('/videos/store', [VideoController::class, 'store'])->name('videos.store');
    Route::get('/videos/look', [VideoController::class, 'look'])->name('videos.look');

    // コメント関連
    Route::post('/recipes/{recipeId}/comment', [CommentController::class, 'store'])->name('comments.store');

    // ユーザー関連
    Route::get('/users/{id}', [UserController::class, 'show'])->name('users.show');
    Route::get('/users/{id}/edit', [UserController::class, 'edit'])->name('users.edit');
    Route::put('/users/{id}', [UserController::class, 'update'])->name('users.update');
    
    
});



