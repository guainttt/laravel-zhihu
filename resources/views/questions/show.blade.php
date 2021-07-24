@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        {{ $question->title }}
                        @foreach($question->topics as $topic)
                            <span > <a class="topic" href="/topic/{{ $topic->id }}">{{$topic->name}}</a></span>

                        @endforeach
                    </div>

                    <div class="card-body card-img">
                       {!! $question->body !!}

                    </div>
                    <div class="action" >
                        @if(Auth::check() && Auth::user()->owns($question))
                            <div >
                                <span style="float: right;padding-right: 10px;">
                                    <a href="/questions/{{$question->id}}/edit">编辑</a>
                                </span>
                                <span style="float: right;padding-right: 10px;">
                                    <form action="/questions/{{$question->id}}" method="POST" class="delete-form">
                                        {{method_field("DELETE")}}
                                        {{csrf_field()}}
                                        <button class="button is-naked delete-button">删除</button>
                                    </form>
                                </span>
                            </div>

                        @endif
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card">
                    <div class="card-header">
                        <h2>{{ $question->followers_count }}</h2>
                        <span>关注者</span>
                    </div>
                    <div class="card-body">

                      {{--  <a href="/questions/{{$question->id}}/follow"
                           class="btn  {{Auth::check() &&  Auth::user()->followed($question->id) ? 'btn-success':'btn-info' }}">
                            {{Auth::check() && Auth::user()->followed($question->id) ?'已关注' :'关注该问题'     }}
                        </a>--}}
                        <question-follow-button question="{{$question->id}}" user="{{Auth::id()}}"></question-follow-button>

                        {{--<my-component></my-component>--}}

                        <a href="#container" class="btn btn-primary">
                            撰写答案
                        </a>
                    </div>
                </div>
            </div>

            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                       {{$question->answers_count}} 个答案
                    </div>
                    <div class="card-body">

                       @foreach($question->answers as $answer)
                           <div class="media">
                              <div class="media">
                                  <div class="left">
                                      <a href="">
                                         <img width="36" src="{{$answer->user->avatar}}" alt="{{ $answer->user->name }}">
                                      </a>
                                  </div>
                                  <div class="media-body">
                                      <h4 class="media-heading">
                                          <a href="/user/{{$answer->user->name}}">
                                              {{$answer->user->name}}
                                          </a>
                                      </h4>
                                      {!! $answer->body !!}
                                  </div>
                              </div>
                           </div>
                       @endforeach

                       @if(Auth::check())

                       <form action="/questions/{{$question->id}}/answer" method="post">
                           {!! csrf_field() !!}
                           <div class="form-group">

                               <label for="container"><h5>回答 </h5> </label>
                               <script id="container" name="body" type="text/plain" style = "height: 120px;">{!! old('body') !!}</script>
                               @if ($errors->any())
                               <div class="alert alert-danger">
                               <ul>
                                   @foreach ($errors->all() as $error)
                               <li>{{ $error }}</li>
                                   @endforeach
                               </ul>
                               </div>
                               @endif
                               <button class="btn btn-success pull-right" type="submit">提交</button>
                           </div>
                        </form>
                        @else
                        <?php
                         session(['redirectTo' => "/questions/$question->id"]);
                        ?>
                        <a href="{{url('login')}}?redirectTo=/questions/{{$question->id}}"  class="btn btn-success btn-block">登录提交答案</a>
                        @endif
                    </div>
               </div>
            </div>
            <div class="col-md-3">
                                       
            </div>

        </div>
    </div>



    

                                   
@endsection

@include('vendor.ueditor.assets')
@section('my-js')
    <!-- 实例化编辑器 -->
    <script type="text/javascript">
        @if(Auth::check())
        //编辑器
        var ue = UE.getEditor('container', {
            toolbars: [
                ['bold', 'italic', 'underline', 'strikethrough', 'blockquote', 'insertunorderedlist', 'insertorderedlist', 'justifyleft','justifycenter', 'justifyright',  'link', 'insertimage', 'fullscreen']
            ],
            elementPathEnabled: false,
            enableContextMenu: false,
            autoClearEmptyNode:true,
            wordCount:false,
            imagePopup:false,
            autotypeset:{ indent: true,imageBlockLine: 'center' }
        });

        ue.ready(function() {
            ue.execCommand('serverparam', '_token', '{{ csrf_token() }}'); // 设置 CSRF token.
        });
        @endif
    </script>
@endsection

