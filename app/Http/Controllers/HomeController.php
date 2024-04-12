<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

// モデルをインポート
use App\Models\User; 
use App\Models\Recipe;
use App\Models\Ingredient;
use App\Models\Comment;
use App\Models\Keyword;
use App\Models\RecipeRating;




class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */

    
    public function index()
    {
        // ランダムで8枚の画像を取得
        $randomImages = Recipe::inRandomOrder()->take(8)->get();
    
        // 材料キーワードを取得
        $keywords = Keyword::orderBy('created_at', 'asc')->take(10)->get();
    
        return view('home', compact('randomImages', 'keywords'));
    }
    
    
}
