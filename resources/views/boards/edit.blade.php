@extends('layouts.layout')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-10 col-md-offset-1">
                <div class="panel panel-default">
                    <div class="panel-heading">게시물 수정</div>

                    <div class="panel-body">
                        <form action="{{ url('board/' . $board->id) }}" method="post" enctype="multipart/form-data" class="form-horizontal">
                            {!! csrf_field() !!}
                            {!! method_field('PUT') !!}
                            <div class="form-group {{ $errors->has('title') ? 'has-error' : '' }}">
                                <label for="title" class="col-sm-2 control-label">제목</label>
                                <div class="col-sm-9">
                                    <input type="text" name="title" id="title" class="form-control" value="{{ old('title') ? old('title') : $board->title }}">
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
                                    <textarea name="body" id="body" cols="30" rows="15" class="form-control">{{ old('body') ? old('body') : $board->body }}</textarea>
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
                                    <button type="submit" class="btn btn-default">
                                        <i class="fa fa-wrench"></i> 수정 완료
                                    </button>
                                </div>
                            </div>



                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
    </div>
@endsection