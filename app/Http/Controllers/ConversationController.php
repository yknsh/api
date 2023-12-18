<?php

namespace App\Http\Controllers;

use App\Models\Conversation;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ConversationController extends Controller
{
    public function all(){
        return Conversation::select('conversation_id','response','is_final')->get();
    }
    public function view($conversation_id){
        return Conversation::select('conversation_id','response','is_final')->where('conversation_id', $conversation_id)->get();
    }
    public function index(Request $request){
        $newConv= Conversation::create([
            'conversation_id' => Str::random(10),
            'response' => 'response',
        ]);
        $newConvId= $newConv->conversation_id;
        return Conversation::select('conversation_id','response','is_final')->where('conversation_id', $newConvId)->get();
    }
}
