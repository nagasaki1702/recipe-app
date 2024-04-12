<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Hash; // Hashファサードの名前空間を追加
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

// モデルをインポート
use App\Models\User;
use App\Models\Recipe;
use App\Models\Ingredient;
use App\Models\RecipeRating;



class UserController extends Controller
{
//ユーザー情報を表示する
    public function show()
    {
        $user = Auth::user();

        return view('users.show', compact('user'));
    }


// ユーザー情報の編集画面を表示するために必要な情報を持ってくる動作
    public function edit($id)
    {
        $user = User::find($id);

            if (!$user) {
                // ユーザーが存在しない場合、エラーハンドリングを行うかリダイレクトなどを実施することができます
                // ここでは例としてエラーメッセージを設定しています
                return redirect()->route('home')->with('error', 'ユーザーが見つかりませんでした');
            }

        return view('users.edit', compact('user'));
    }


// 更新する動き
    public function update(Request $request, $id)
    {
        $user = User::find($id);
    
        $user->name = $request->input('name');
        $user->email = $request->input('email');
    
        // パスワードの更新を行うかどうかを確認
        if ($request->filled('password')) {
            $user->password = Hash::make($request->input('password'));
        }
    
        // 自己紹介の更新
        $user->introduction = $request->input('introduction');
    
        // 画像アップロードを処理
        if ($request->hasFile('image')) {
            // 画像のアップロード処理
            $image = $request->file('image');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $image->storeAs('public/user_images', $imageName); // 画像をpublicディスクの指定のディレクトリに保存
    
            // 古い画像を削除
            if ($user->image) {
                $oldImagePath = str_replace('storage', 'public', $user->image);
                Storage::delete($oldImagePath);
            }
    
            // ユーザーのプロフィール画像を更新
            $user->image = 'storage/user_images/' . $imageName;
        }
    
        $user->save();
        return redirect()->route('users.show', ['id' => $user->id]);
    }


}
