@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ $question->title }}</div>
                    @foreach($question->topics as $topic)
                        <span > <a class="topic" href="/topic/{{ $topic->id }}">{{$topic->name}}</a></span>

                    @endforeach
                    <div class="card-body card-img">
                       {!! $question->body !!}

                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
<style>
    .card-img p img {
        max-width: 100%  !important;
    }
</style>

<link rel="stylesheet" href="./../css/style.css">

