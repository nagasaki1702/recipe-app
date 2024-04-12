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
                    <h1>アカウント情報</h1>
                </div>
                <div class="card-body">
                    <div class="form-group mb-3 text-center">

                        {{-- ユーザーのアイコン画像 --}}
                        <label style="margin-bottom: 3px; text-align: left;"><strong>Icon:</strong></label>
                        @if (Auth::user()->image)
                        <img src="{{ asset('storage/user_images/' . basename($user->image)) }}" alt="{{ $user->name }}" class="img-thumbnail mx-auto rounded-circle" style="width: 200px; height: 200px; display: block;">
                        @else
                        <img src="{{ asset('imgs/user-default.png') }}" alt="デフォルトアイコン" class="img-thumbnail mx-auto rounded-circle" style="width: 200px; height: 200px; display: block;">
                        @endif  
                        {{-- ユーザーのアイコン画像 --}}


                    </div>                    
                    <p><strong>Name:</strong> {{ $user->name }}</p>
                    <p><strong>Email:</strong> {{ $user->email }}</p>
                    <p><strong>Other information:</strong> Additional information goes here...</p>
                    {{-- ユーザーの自己紹介 --}}
                    @if (Auth::user()->introduction)
                        <p>自己紹介: {{ Auth::user()->introduction }}</p>
                    @endif
                    {{-- ユーザーの自己紹介 --}}
                    <div class=" text-center">
                        <a href="{{ route('users.edit', ['id' => $user->id]) }}" class="btn btn-primary"> 編 集 </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
