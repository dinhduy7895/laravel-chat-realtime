<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Request;
use Redis;

class SingleController extends ConversationControllel
{
    public function chat($id)
    {
        $user_partner = \App\User::find($id);
        $coversation = new \App\Conversation();
        $coversation->startToChat($id);
        $messages = $coversation->loadMessages($id);
        return view('single.chat',compact('user_partner','messages'));
    }

    public function send(){

        $data = ['message' => Request::input('message'), 'user' => Request::input('user')];
        $data['message_type'] = 'text';
        $coversation = new \App\Conversation();
        $partner = Request::input('partner');
        $partner = \App\User::where('username', $partner)->first();
        $coversation->insertMessage($partner->id, $data);
        Redis::publish('test-channel', json_encode($data));
        return response()->json([]);
    }
}
