@extends('layouts.app')

@section('content')
     @include('vendor.ueditor.assets')
     <div class="container">
         <div class="row justify-content-center">
            <div class="col-md-8 col-md-offset-2">
                <div class="card">
                    <div class="card-header">发布问题</div>
                    <div class="card-body">
                        <form action="/questions" method="post">
                            {!! csrf_field() !!}
                            <div class="form-group">
                                <label for="title"><h5>标题 </h5> </label>
                                <input id="title" type="text" name="title" class="form-control @error('title') is-invalid @enderror" placeholder="标题" value="{{ old('title') }}">

                                @if($errors->has('title'))
                                    <div class="alert alert-danger">
                                        <ul>
                                            <li>{{ $errors->first('title') }}</li>
                                        </ul>
                                    </div>
                                @endif

                                @if ($errors->any())
                                    <div class="alert alert-danger">
                                        <ul>
                                            @foreach ($errors->all() as $error)
                                                <li>{{ $error }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                @endif

                            </div>
                            <div class="form-group">
                                <label for="topic"><h5>话题</h5></label>
                                <select  class="js-example-basic-multiple js-example-data-ajax form-control" name="topics[]" multiple="multiple">

                                    @foreach ($oldTopicList as $k=>$topic)
                                        <option value="{{is_numeric($k)?:$topic}}" selected="selected">
                                            {{ $topic }}
                                        </option>
                                    @endforeach
                                   
                                </select>



                                {{--<select name="topics[]"   class="js-example-basic-multiple js-example-data-ajax form-control" multiple>
                                    @foreach($settings->includes->get('topics') as $option)
                                        <option value="{{ $option->id }}" {{ (collect(old('topics'))->contains($option->id)) ? 'selected':'' }}>{{ $option->name }}</option>
                                    @endforeach
                                </select>

                                <select id="forWhom" name="topics[]" multiple class="form-control chosen">
                                    <option value="">--- Select ---</option>
                                    @foreach ($desgInfo as $key => $value)
                                        <option value="{{ $key }}"
                                                {{ (collect(old('forWhom'))->contains($key)) ? 'selected':'' }}  />
                                        {{ $value }}
                                        </option>
                                    @endforeach
                                </select>--}}

                                
                            </div>
                            <div class="form-group">
                                <label for="container"><h5>描述 </h5> </label>
                                <!--text/plain的意思是将文件设置为纯文本的形式，浏览器在获取到这种文件时并不会对其进行处理-->
                                <!-- 转义 {{ old('body') }} -->
                                <!-- 非转义 {!! old('body') !!} -->
                               
                                <!-- 编辑器容器 -->
                                <script id="container" name="body" type="text/plain" style = "height: 200px;">{!! old('body') !!}</script>
                                
                                <button class="btn btn-success pull-right" type="submit">发布问题</button>
                             </div>
                        </form>

                    </div>
                </div>
            </div>
        </div>
     </div>



    @section('my-js')


    <script type="text/javascript">

                                        


    $(function(){
        $(".js-example-data-ajax").select2({
            tags: true,
            placeholder: '请选择相关的话题',
            minimumInputLength: 1,
            ajax: {
                url: "/api/topics",
                dataType: 'json',
                delay: 250,
                data: function (params) {
                    return {
                        q: params.term, // search term
                        page: params.page
                    };
                },
                processResults: function (data, params) {
                    // parse the results into the format expected by Select2
                    // since we are using custom formatting functions we do not need to
                    // alter the remote JSON data, except to indicate that infinite
                    // scrolling can be used
                    params.page = params.page || 1;

                    return {
                        results: data,
                        pagination: {
                            more: (params.page * 30) < data.total_count
                        }
                    };
                },
                cache: true
            },
            templateResult: formatRepo,
            templateSelection: formatRepoSelection
        });


        
        function formatRepo (repo) {
            if (repo.loading) {
                return repo.text;
            }

            return "<div class='select2-result-repository clearfix'>"+
            "<div class='select2-result-repository__meta'>" +
            "<div class='select2-result-repository__title'>" +
            repo.name?repo.name:"laravel" +
                "</div></div></div>";
        }

        function formatRepoSelection (repo) {
            return repo.name || repo.text;
        }
    });
    </script>


    <!-- 实例化编辑器 -->
    <script type="text/javascript">
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

    </script>
    @endsection
@endsection