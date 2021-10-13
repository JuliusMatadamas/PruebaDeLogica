<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function(){
    return view('menu');
})->name('home');

Route::get('/fileupload', 'FileUploadController@fileUpload')->name('file.upload');
Route::post('/fileupload', 'FileUploadController@fileUploadPost')->name('file.upload.post');
Route::get('/lightedroom', 'LightedRoomController@index')->name('lighted.room');
