<?php

namespace App\Http\Controllers;

use App\Models\Conversation;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use OpenAI;

class ConversationController extends Controller
{
    public function open_ai($prompt){
        $key = env('API_KEY');
        $client = OpenAI::client($key);

        $result = $client->chat()->create([
            'model' => 'gpt-3.5-turbo',
            'max_tokens' => 90,
            "messages" => [['role' => 'user', 'content' => $prompt],],
        ]); 

        return $result->choices[0]->message->content;
    }
    

    public function all(){
        return Conversation::select('conversation_id','response','is_final')->get();
    }

    public function view($conversation_id){
        return Conversation::select('conversation_id','response','is_final')->where('conversation_id', $conversation_id)->get();
    }

    public function create(Request $request){
        $result= $this->open_ai($request->input('prompt'));

        $newConv= Conversation::create([
            'conversation_id' => Str::random(10),
            'response' => $result,
        ]);
        return Conversation::select('conversation_id','response','is_final')->where('conversation_id', $newConv->conversation_id)->get();
    }

    public function cont(Request $request, $conversation_id){
        Conversation::where('conversation_id', $conversation_id)->update(['is_final'=> 'true']);

        return Conversation::select('conversation_id','response','is_final')->where('conversation_id', $conversation_id)->get();
    }



    public function del($conversation_id){
        Conversation::where('conversation_id',$conversation_id)->delete();

        return Conversation::select('conversation_id','response','is_final')->get();
    }

    public function delAll(){
        Conversation::truncate();

        return Conversation::select('conversation_id','response','is_final')->get();
    }
}
