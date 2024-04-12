<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Video;

class VideoController extends Controller
{
    // 動画投稿画面の表示
    public function up()
    {
        return view('videos.up');
    }

    // 動画を投稿して保存する動き
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'description' => 'nullable', // 追加: 説明はオプションとして扱う
            'video' => 'required|mimes:mp4,mov,avi,wmv|max:10240',
        ]);

        // 現在認証されているユーザーのIDを取得
        $userId = Auth::id();

        $video = new Video;
        $video->title = $request->title;
        $video->description = $request->description; // 追加: 説明を保存
        $video->user_id = $userId;

        // 動画を保存
        $videoPath = $request->file('video')->store('videos', 'public');
        $video->filename = $videoPath;

        $video->save();

        return redirect()->route('videos.up')->with('success', '動画がアップロードされました。');
    }

    // 動画の一覧を表示する
    public function look()
    {
        $videos = Video::all();

        return view('videos.look', compact('videos'));
    }
}
