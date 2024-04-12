@extends('layouts.app')

@section('content')
<div class="container section-padding">
    <h2>動画を投稿する</h2>
    <div class="row flex-md-row">
        <div class="col-md-7">
            <form action="{{ route('videos.store') }}" method="post" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="user_id" value="{{ Auth::id() }}">
                
                <div class="form-group my-1">
                    <label for="title">タイトル:</label>
                    <input type="text" name="title" class="form-control" required>
                </div>

                <div class="form-group my-1">
                    <label for="description">説明:</label>
                    <textarea name="description" class="form-control" rows="4"></textarea>
                </div>

                <div class="form-group custom-form my-1">
                    <label for="video">動画ファイル:</label>
                    <input class="form-control" type="file" name="video" accept="video/*" required>
                </div>

                <div class="d-flex justify-content-center align-items-center mt-2">
                    <div class="me-3">
                        <button type="submit" class="btn btn-primary my-1">アップロード</button>
                    </div>

                    <div class="">
                        <a href="{{ route('videos.look') }}" class="btn btn-secondary">動画一覧</a>
                    </div>
                </div>
            </form>
        </div>
        
        <div class="col-md-5">
            <div class="mb-3 text-center">
                <label style="font-size: 24px; margin-bottom: 3px; text-align: left;" class="">あなたにおすすめのレシピ</label>
                <img src="{{ asset('imgs/10.png') }}" alt="デフォルト画像" class="img-thumbnail mx-auto" style="width: 20rem; height: 20rem; display: block;">
            </div>
        </div>
    </div>
</div>
<script>
    
</script>
@endsection
