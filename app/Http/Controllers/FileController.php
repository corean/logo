<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

use App\Http\Requests;
use App\Fileentry;
use App\Board;

class FileController extends Controller
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
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * 파일 업로드
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Board $board
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Board $board)
    {
        /* 글 수정인지 수정이면 append */
        if (Board::FindorFail($board->id)->files) {
            $files[] = unserialize($board->files);
        }

        foreach ($request->file('files') as $uploadFile ) {
            $file = new Fileentry;
            $extension = $uploadFile->getClientOriginalExtension();
            $newFileName = substr(sha1(mt_rand()), 0, 10) . '.' . $extension;
            $file->user_id = $request->user()->id;
            $file->board_id = $board->id;
            $file->original_name = $uploadFile->getClientOriginalName();
            $file->file_name = $newFileName;
            $file->file_size = $uploadFile->getClientSize();
            $file->file_type = $uploadFile->getClientMimeType();
            $uploadFile->move(public_path() . '/uploads', $newFileName);
            \Debugbar::info($uploadFile->isValid());
            $file->save();
            $files[] = $file->id;

        }
        $board->files = serialize($files);
        $board->save();
        return $files;
    }

    /**
     * 파일 보기
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $file = Fileentry::FindOrFail($id);
        $fileLocation = public_path() . '/uploads/' . $file->file_name;
        $original_name = $file->original_name;
        $header = [
            'Content-Type: ' . $file->file_type,
            'Content-Disposition: attachment; filename="' . $original_name . '"',
            'Content-Transfer-Encoding: binary',
            'Content-length: ' . $file->file_size
        ];
        return response()->file($fileLocation, $header);
    }

    /**
     * 파일 다운로드
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function download($id)
    {
        $file = Fileentry::FindOrFail($id);
        $fileLocation = public_path() . '/uploads/' . $file->file_name;
        if (!File::exists($fileLocation)) {
            return back()->with('flash_message', '해당 파일이 없습니다.');
        }
        $original_name = $file->original_name;
        $header = [
            'Content-Type: ' . $file->file_type,
            'Content-Disposition: attachment; filename="' . $original_name . '"',
            'Content-Transfer-Encoding: binary',
            'Content-length: ' . $file->file_size
        ];
        return response()->download($fileLocation, $original_name, $header);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $file = Fileentry::findOrFail($id);
        $result = File::delete(public_path() . '/uploads/' .  $file->file_name);
        if (!$result) {
            return back()->with('flash_message', '파일이 삭제되지 않았습니다.');
        }
        $board = Board::findOrFail($file->board_id);
        $files = unserialize($board->files);
        if ($key = array_search($file->id, $files) != false) {
            unset($files[$key]);
        }
        $board->files = serialize($files);
        $board->save();
        $file->delete();
        return back()->with('flash_message', '파일이 삭제되었습니다.');

    }
}
