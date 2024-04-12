@extends('layouts.app')

@section('content')
<div class="container section-padding">
    <h2>動画一覧</h2>
        <div class="row">
            @foreach($videos as $video)
                <div class="col-md-4 mb-4">
                    <div class="card">
                        <h3 class="card-title m-auto">{{ $video->title }}</h3>
                        <div class="card-body">
                            <p class="card-text">{{ $video->description }}</p>

                            <video width="320" height="180" controls>
                                <source src="{{ asset('storage/' . $video->filename) }}" type="video/mp4">
                                お使いのブラウザは動画タグをサポートしていません。
                            </video>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endsection
