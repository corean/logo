<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::auth();
Route::get('/boards', 'boardController@index')->name('boards');
Route::resource('/board', 'boardController');
Route::get('/files', 'fileController@index')->name('files');
Route::get('/file/download/{id}', 'fileController@download');
Route::resource('/file', 'fileController');
