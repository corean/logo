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
                <div class="panel-heading">
                    {{ $board->title }}
                </div>

                <div class="panel-body">
                    <p class="text-right">
                        <i class="fa fa-clock-o"></i> {{ $board->created_at }}
                    </p>

                    {!! nl2br(e($board->body)) !!}

                    <br>
                    {{-- 파일 보기 --}}
                    @if (!empty($files))
                        <ul class="files">
                            @foreach($files as $file)
                                <li><a href="/file/download/{{ $file->id }}">{{ $file->original_name }}</a></li>

                            @endforeach
                        </ul>
                    @endif

                    <hr>
                    <div class="row">
                        <div class="col-sm-6">
                            <a href="{{ url(route('boards')) }}" class="btn btn-default" role="button">
                                <i class="fa fa-list"></i> 글목록
                            </a>
                        </div>
                        <div class="col-sm-6">
                            <div class="btn-group pull-right" role="group">
                                <a href="{{ url('board/' . $board->id . '/edit') }}" class="btn btn-default"
                                   role="button"><i class="fa fa-wrench"></i> 글수정</a>
                                <a href="{{ url('board/create') }}" class="btn btn-default" role="button"><i
                                            class="fa fa-plus"></i> 글작성</a>
                            </div>
                            {{-- todo 수정/삭제 권한 설정 --}}
                            <form action="{{ url('board/' . $board->id) }}" method="post">
                                {{ csrf_field() }}
                                {{ method_field('DELETE') }}
                                <button type="submit" class="btn btn-default pull-right margin-right-5px"><i
                                            class="fa fa-trash"></i> 글삭제
                                </button>
                            </form>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection