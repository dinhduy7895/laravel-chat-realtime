<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Request;
use Redis;
use App\Repositories\Conversation\ConversationRepositoryInterface;
class SingleController extends ConversationControllel
{
    protected $conversationRepository;
    public function __construct(ConversationRepositoryInterface $conversationRepository)
    {
        $this->conversationRepository = $conversationRepository;
    }
    
    public function chat($id)
    {
        $user_partner = \App\User::find($id);
        $this->conversationRepository->startToChat($id);
        $messages = $this->conversationRepository->loadMessages($id);
        return view('single.chat',compact('user_partner','messages'));
    }

    public function send(){

        $data = ['message' => Request::input('message'), 'user' => Request::input('user')];
        $data['message_type'] = 'text';
        $partner = Request::input('partner');
        $partner = \App\User::where('username', $partner)->first();
        $this->conversationRepository->insertMessage($partner->id, $data);
        Redis::publish('test-channel', json_encode($data));
        return response()->json([]);
    }
}
