@extends('layouts.layout')

@section('content')
    @if(session()->has('flash_message'))
        <div class="row">
            <div class="col-md-offset-1 col-md-10">
                <div class="alert alert-danger" role="alert">
                    <buttn type="close" class="close" data-dismiss="alert">&times;</buttn>
                    {{ session('flash_message') }}
                </div>
            </div>
        </div>
    @endif

    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading">게시물 수정</div>

                <div class="panel-body">
                    <form id="editBoard" action="{{ url('board/' . $board->id) }}" method="post"
                          enctype="multipart/form-data" class="form-horizontal">
                        {!! csrf_field() !!}
                        {!! method_field('PUT') !!}
                        <div class="form-group {{ $errors->has('title') ? 'has-error' : '' }}">
                            <label for="title" class="col-sm-2 control-label">제목</label>
                            <div class="col-sm-9">
                                <input type="text" name="title" id="title" class="form-control"
                                       value="{{ old('title') ? old('title') : $board->title }}">
                                @if ($errors->has('title'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('title') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group {{ $errors->has('body') ? 'has-error' : '' }}">
                            <label for="body" class="col-sm-2 control-label">내용</label>
                            <div class="col-sm-9">
                                <textarea name="body" id="body" cols="30" rows="15"
                                          class="form-control">{{ old('body') ? old('body') : $board->body }}</textarea>
                                @if ($errors->has('body'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('body') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="files" class="col-sm-2 control-label">파일</label>
                            <div class="col-sm-9">

                                <input type="file" name="files[]" id="files" multiple="multiple">
                                @if ($errors->has('files'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('files') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-offset-2 col-sm-7">
                                <button type="submit" class="btn btn-default" form="editBoard">
                                    <i class="fa fa-wrench"></i> 수정 완료
                                </button>
                            </div>
                        </div>
                    </form>
                    {{-- 파일 보기 --}}
                    @if (!empty($files))
                        <div class="form-group">
                            <div class="col-sm-2 text-right">이전 파일</div>
                            <div class="col-sm-9">
                                <ul class="files">
                                    @foreach($files as $file)
                                        <li>
                                            <form id="deleteFile" action="{{ url('file/' . $file->id) }}" method="post">
                                                {!! csrf_field() !!}
                                                {!! method_field('DELETE') !!}
                                                {{ $file->original_name }}
                                                <button type="submit" class="btn btn-danger btn-xs">삭제</button>
                                            </form>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection