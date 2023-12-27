<?php

namespace App\Http\Controllers;

use App\Models\Conversation;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ConversationController extends Controller
{
    
    public function generator($id){

        $currConv = Conversation::where('conversation_id', $id)->value('response');
        
        $result = array("lorem ipsum ","dolor sit amet, ","magna aliqua.", "consectetur adipiscing ", "elit, sed ", "do eiusmod ", "tempor incididunt, ", "ut labore ","et dolore.");
        
        $conv = "";
        
        if($currConv == ""){
            $nxtUpper=true;
        }else{
            $nxtUpper=false;
        }
        foreach ($result as $key) {
            $rand = \Arr::random($result);
            
            if($nxtUpper===true){
                $rand = ucfirst($rand);
                $nxtUpper = false;
            }
            if(Str::endsWith($rand,'.')){
                $rand .= " ";
                $nxtUpper = true;
            }
            $conv = $conv . $rand;
        }
        // $alp =  range('A', 'Z');
        $conv = trim($conv, substr($conv, -1));
        $conv = " " . $conv;
        
        return $conv;
    }

    public function all(){
        return Conversation::select('conversation_id','response','is_final')->get();
    }

    public function view($id){

        $response = $this->generator($id);

        $isfinal = Conversation::where('conversation_id', $id)->value('is_final');

        $currConv = Conversation::where('conversation_id', $id)->value('response');

        if($isfinal == 'true'){
            return Conversation::select('conversation_id','response','is_final')->where('conversation_id', $id)->get();
        }else{
            Conversation::where('conversation_id',$id)->update(['response' => $currConv . $response]);

            if(Str::endsWith($response,'.')){
                Conversation::where('conversation_id',$id)->update(['is_final' => 'true']);
            }
        }
        return Conversation::select('conversation_id','response','is_final')->where('conversation_id', $id)->get();
    }

    public function create(Request $request){
        
        $conversation = Conversation::create([
            'conversation_id' => Str::random(10),
            'response' => '',
        ]);
        
        return Conversation::select('conversation_id','response','is_final')->where('conversation_id', $conversation->conversation_id)->get();
    }

    public function cont(Request $request, $conversation_id){
        Conversation::where('conversation_id',$conversation_id)->update(['response' => '', 'is_final' => 'false']);

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
