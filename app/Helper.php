<?php


namespace App; 


class Helper
{
    public static function get(string $id){

        $req = \Request::create('/api/chat/conversation/'.$id,'GET');
        $req = \Route::dispatch($req);
        $req = json_decode($req->getContent(),true);
        
        if($req[0]['is_final'] != 'true'){
            do{
                $req = \Request::create('/api/chat/conversation/'.$id,'GET');
                $req = \Route::dispatch($req);
                $req = json_decode($req->getContent(),true);
            }while($req[0]['is_final'] == 'false');
        }
    
        return $req;

    }

    public static function put(string $id){
        $put = \Request::create('/api/chat/conversation/'.$id,'PUT');
        $put = \Route::dispatch($put);
    }

    public static function post(){
        $post = \Request::create('/api/chat/conversation/','post');
        $post = \Route::dispatch($post);
        $post = json_decode($post->getContent(),true);
        var_dump($post[0]['conversation_id']);
        return \Redirect::to('/chat/conversation?conversation_id='.$post[0]['conversation_id']);
    }

    public static function delete(string $id){
        $delete = \Request::create('/api/chat/conversation/'.$id,'delete');
        $delete = \Route::dispatch($delete);
        return \Redirect::to('/chat/conversation');
    }
}



?>