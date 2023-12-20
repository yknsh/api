<?php

namespace App\Http\Controllers;

use App\Models\Conversation;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ConversationController extends Controller
{
    
    public function handle(\OpenAI\Client $client, $prompt = null)
{
    $result = $client->completions()->create([
        'prompt' => $prompt,
        'model' => 'gpt-3.5-turbo-instruct',
        'max_tokens' => 20,
    ]);

    return $result->choices[0]->text;

}

    public function all(){
        return Conversation::select('conversation_id','response','is_final')->get();
    }

    public function view($conversation_id){

        return Conversation::select('conversation_id','response','is_final')->where('conversation_id', $conversation_id)->get();
    }

    public function create(Request $request){
        
        $prompt = $request->input('prompt');
        
        $result = $this->handle(app(\OpenAI\Client::class), $prompt);

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
