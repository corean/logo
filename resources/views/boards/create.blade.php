@extends('layouts.layout')

@section('style')
    <link rel="stylesheet" href="/packages/dropzone/dropzone.css">
@endsection

@section('content')
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading">게시물 작성</div>

                <div class="panel-body">
                    <form action="{{ url('/board') }}" method="post" enctype="multipart/form-data"
                          class="form-horizontal">
                        {!! csrf_field() !!}
                        <div class="form-group {{ $errors->has('title') ? 'has-error' : '' }}">
                            <label for="title" class="col-sm-2 control-label">제목</label>
                            <div class="col-sm-9">
                                <input type="text" name="title" id="title" class="form-control"
                                       value="{{ old('title') }}">
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
                                    <textarea name="body" id="body" cols="30" rows="10"
                                              class="form-control">{{ old('body') }}</textarea>
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
                                <div class="dz-message"></div>
                                <div class="fallback">
                                    <input type="file" name="files[]" id="files" multiple="multiple">
                                </div>
                                @if ($errors->has('files'))
                                    <span class="help-block">
                                            <strong>{{ $errors->first('files') }}</strong>
                                        </span>
                                @endif
                                <div class="dropzone" id="dropzoneFileUpload"></div>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-sm-offset-2 col-sm-7">
                                <button type="submit" class="btn btn-default">
                                    <i class="fa fa-plus"></i> 작성완료
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection