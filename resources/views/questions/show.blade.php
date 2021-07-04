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
                    <div class="action">
                        @if(Auth::check() && Auth::user()->owns($question))
                            <span class="edit" style="display: inline">
                                <a href="/questions/{{$question->id}}/edit">编辑</a>
                                
                                <form action="/questions/{{$question->id}}" method="POST" class="delete-form">
                                    {{method_field("DELETE")}}
                                    {{csrf_field()}}
                                    <button class="button is-naked delete-button">删除</button>
                                </form>
                            </span>
                        @endif
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



