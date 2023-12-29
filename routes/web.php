<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/chat',function(){return view('chat');});
Route::get('/chat/conversation',function(){return view('conversation');});
Route::put('/chat/conversation' ,function(){return view('conversation');});
Route::post('/chat/conversation' ,function(){return view('conversation');});