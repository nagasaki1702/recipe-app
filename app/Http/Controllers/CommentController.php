<?php
namespace App\Http\Controllers;

use Illuminate\Support\Facades\Storage; // Storage クラスを使用するために追加
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


use App\Models\User; // モデルをインポート
use App\Models\Recipe; // モデルをインポート
use App\Models\Ingredient; // モデルをインポート
use App\Models\Comment; // モデルをインポート



class CommentController extends Controller 
    {
    // コメントを保存
    public function store(Request $request, $recipeId)
    {
        $comment = new Comment();
        $comment->user_id = auth()->user()->id; // ログインユーザーのIDをセット
        $comment->comment = $request->input('comment');
        $comment->recipe_id = $recipeId; // レシピのIDをセット
        $comment->save();
    
        return redirect()->back()->with('success', 'コメントが投稿されました。');
    }
}
