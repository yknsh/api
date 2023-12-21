<?php

use App\Http\Controllers\ConversationController;
use App\Models\Conversation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::get('/chat/conversation', [ConversationController::class, 'all']);
Route::get('/chat/conversation/{conversation_id}', [ConversationController::class, 'view']);
Route::post('/chat/conversation', [ConversationController::class, 'create']);
Route::put('/chat/conversation/{conversation_id}', [ConversationController::class,'cont']);
Route::delete('/chat/conversation/{conversation_id}', [ConversationController::class,'del']);
Route::delete('/chat/conversation/', [ConversationController::class,'delAll']);