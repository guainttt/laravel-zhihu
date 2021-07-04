@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8 col-md-offset-2">
              @foreach($questions as $question)
                  <div class="media-left">
                      <a href="">
                          <img width="50px" src="{{$question->user->avatar}}" alt="{{$question->user->name}}">
                      </a>
                  </div>
                  <div class="media-body">
                      <h4 class="media-heading">
                          <a href="/questions/{{$question->id}}"> {{$question->title}}</a>

                      </h4>
                  </div>
              @endforeach
            </div>
        </div>
    </div>

@endsection




