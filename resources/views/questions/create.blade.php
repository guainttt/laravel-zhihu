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
                            <!--text/plain的意思是将文件设置为纯文本的形式，浏览器在获取到这种文件时并不会对其进行处理-->
                            <!-- 转义 {{ old('body') }} -->
                            <!-- 非转义 {!! old('body') !!} -->
                            <script id="container" name="body" type="text/plain" >
                                {!! old('body') !!}
                            </script>
                            <button class="btn btn-success pull-right" type="submit">发布问题</button>
                        </form>

                    </div>
                </div>
            </div>
         </div>
     </div>

<!-- 实例化编辑器 -->
<script type="text/javascript">
    var ue = UE.getEditor('container');
    ue.ready(function() {
        ue.execCommand('serverparam', '_token', '{{ csrf_token() }}'); // 设置 CSRF token.
    });
</script>

<!-- 编辑器容器 -->
<script id="container" name="content" type="text/plain"></script>
    
@endsection