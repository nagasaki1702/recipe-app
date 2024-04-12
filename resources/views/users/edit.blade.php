@extends('layouts.app')

@section('content')

<style>
    /* 背景ドット柄のCSS */
    body {
        background-color: #f7f7f7; /* ドット柄の背景色 */
        background-image: radial-gradient(circle at 4px 4px, transparent 3px, #fff 4px);
        background-size: 8px 8px;
    }
</style>

<div class="container section-padding">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h1>アカウント情報 編集画面</h1>
                </div>
                <div class="card-body">
                    <label for="icon">現在のアイコン</label>
                    @if ($user->image)
                    <img src="{{ asset('storage/user_images/' . basename($user->image)) }}" alt="{{ $user->name }}" class="img-thumbnail mx-auto rounded-circle" style="width: 200px; height: 200px; display: block;">
                    @else
                    <img src="{{ asset('imgs/user-default.png') }}" alt="デフォルトアイコン" class="img-thumbnail mx-auto rounded-circle" style="width: 200px; height: 200px; display: block;">
                    @endif                    
                    <form method="POST" action="{{ route('users.update', ['id' => $user->id]) }}" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="form-group">
                            <label for="name">Name</label>
                            <input type="text" name="name" value="{{ old('name', $user->name) }}" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="email">Email</label>
                            <input type="email" name="email" value="{{ old('email', $user->email) }}" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="password">New Password</label>
                            <input type="password" name="password" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="password_confirmation">Confirm New Password</label>
                            <input type="password" name="password_confirmation" class="form-control">
                        </div>
                        <div class="form-group custom-form">
                            <label for="user_image">Icon</label>
                            <input type="file" name="image" id="formFile" class="form-control mt-1 mb-3">
                        </div>
                        {{-- 自己紹介の追加 --}}
                        <div class="form-group">
                            <label for="introduction">自己紹介</label>
                            <textarea name="introduction" class="form-control">{{ old('introduction', $user->introduction) }}</textarea>
                        </div>
                        <div class="form-group mt-3 me-5 text-center">
                            <button type="submit" class="btn btn-primary">上書き保存</button>
                            <a href="{{ route('users.show', ['id' => $user->id]) }}" class="btn btn-secondary ml-2">戻る</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
