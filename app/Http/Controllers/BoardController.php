<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Board;
use Carbon\Carbon;

class BoardController extends Controller
{
    protected $request;

    /**
     * @param Request $request
     */
    public function __construct(Request $request)
    {
        $this->request = $request;
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $boards = Board::orderBy('created_at','desc')->paginate(10);
        \Debugbar::info('BoardController.index');
        $boards->load('user'); //지연로드
        return view('boards.list', [
            'boards' => $boards
        ]);

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('boards.create');
    }

    /**
     * Store a newly created resource in storage.php 
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
//      todo 여러번 submit 금지
//      todo 1분이내 같은 내용인지 확인

        $this->validate($request, [
            'title' => 'required|max:255',
            'body' => 'required|min:5',
        ], [
            'title.required' => ' 제목은 필수입력입니다.',
            'body.required' => '본문은 필수입력입니다.',
            'body.min' => '본문은 최소 :min글자 이상 필요합니다.',

        ]);

        $board = new Board;
        $board->user_id = $request->user()->id;
        $board->title = $request->title;
        $board->body = $request->body;
        $result = $board->save();

        // 업로드 파일처리
        if ($request->hasFile('files')) {
            $upload_success = app('App\Http\Controllers\FileController')->store($request, $board);
            if (!$upload_success) {
                return back()->with('flash_message', ' 업로드가 되지 않았습니다.')->withInput();
            }
        }

        if (!$result) {
            return back()->with('flash_message', ' 글이 저장되지 않았습니다.')->withInput();
        }
        return redirect(route('boards'))->with('flash_message', ' 글이 저장되었습니다.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $board = Board::findOrFail($id);
        $files = $board->files()->get();
        return view('boards.show',['board'=>$board, 'files'=>$files]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $board = Board::findOrFail($id);
        $files = $board->files()->get();

//        dd($board);
        return view('boards.edit',['board'=>$board], ['files'=>$files]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'title' => 'required|max:255',
            'body' => 'required|min:5',
        ], [
            'title.required' => ' 제목은 필수입력입니다.',
            'body.required' => '본문은 필수입력입니다.',
            'body.min' => '본문은 최소 :min글자 이상 필요합니다.',

        ]);
        $board = Board::findOrFail($id);
        $board->title = $request->title;
        $board->body = $request->body;
        $result = $board->save();

        // 업로드 파일처리
        if ($request->hasFile('files')) {
            $upload_success = app('App\Http\Controllers\FileController')->store($request, $board);
            if (!$upload_success) {
                return back()->with('flash_message', ' 업로드가 되지 않았습니다.')->withInput();
            }
        }

        if (!$result) {
            return back()->with('flash_message', ' 글이 수정되지 않았습니다.')->withInput();
        }
        return redirect(route('boards'))->with('flash_message', ' 글이 수정되었습니다.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        /*  todo  글삭제시 파일이나 댓글도 같이 삭제 */
        $result = Board::destroy($id);
        if (!$result) {
            return back()->with('flash_message', ' 글이 삭제되지 않았습니다.')->withInput();
        }
        return redirect(route('boards'))->with('flash_message', ' 글이 삭제되었습니다.');

    }
}
