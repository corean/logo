@extends('layouts.layout')

@section('content')
    @if(session()->has('flash_message'))
        <div class="row">
            <div class="col-md-offset-1 col-md-10">
                <div class="alert alert-success" role="alert">
                    <buttn type="close" class="close" data-dismiss="alert">&times;</buttn>
                    {{ session('flash_message') }}
                </div>
            </div>
        </div>
    @endif
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading">Boards</div>

                <div class="panel-body">
                    <table class="table table-hover">
                        <thead>
                        <tr>
                            <th>제목</th>
                            <th>작성자</th>
                            <th>날짜</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($boards as $board)
                            <tr>
                                <td>
                                    <a href="{{ url('board/'.$board->id) }}">{{ str_limit($board->title, 50, '...') }}</a>
                                </td>
                                <td>{{ str_limit($board->user->name, 20, '...') }}</td>
                                <td>{{ $board->created_at }}</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                    <hr>
                    {{ $boards->links() }}
                    <a href="{{ url('/board/create') }}" class="btn btn-default pull-right" role="button"><i
                                class="fa fa-plus"></i> 작성하기</a>
                </div>
            </div>
        </div>
    </div>
@endsection
