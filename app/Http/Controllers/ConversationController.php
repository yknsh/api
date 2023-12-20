<?php

namespace App\Http\Controllers;

use App\Models\Conversation;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use OpenAI;

class ConversationController extends Controller
{
    public function open_ai()
    {
        $client = \OpenAI::client(env('OPEN_AI_TOKEN'));

        $prompt = "What is Laravel framework";

        $result = $client->completions()->create([
            'model' => "text-davinci-003",
            'prompt' => $prompt,
        ]);

        echo $result['choices'][0]['text'];
    }
    

    public function all(){
        return Conversation::select('conversation_id','response','is_final')->get();
    }

    public function view($conversation_id){

        return Conversation::select('conversation_id','response','is_final')->where('conversation_id', $conversation_id)->get();
    }

    public function create(Request $request){
        
        $client = OpenAI::client(getenv('OPEN_AI_TOKEN'));

        $result = $client->completions()->create([
            'model' => "text-davinci-003",
            'prompt' => $request,
        ]);

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
}
