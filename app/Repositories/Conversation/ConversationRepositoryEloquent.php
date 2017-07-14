<?php

namespace App\Repositories\Conversation;
use Auth;
use  Illuminate\Support\Facades\DB;
class ConversationRepositoryEloquent implements ConversationRepositoryInterface
{
    public function startToChat($id)
    {
        $conversation = $this->getConversation($id);
        $conversation_id = $this->getConversationId($conversation);
        if ($conversation_id == 0) {
            $conversation = new \App\Conversation();
            $conversation->title = Auth::user()->id . '-' . $id;
            $conversation->channel_id = 'single:' . $conversation->title;
            $user = Auth::user();
            $user->conversations()->save($conversation);
            $conversation_id = $conversation->id;
            DB::table('participants')->insert([
                ['conversation_id' => $conversation_id, 'users_id' => Auth::user()->id, 'type' => 'single'],
                ['conversation_id' => $conversation_id, 'users_id' => $id, 'type' => 'single'],
            ]);
        }
    }

    public function getConversation($id)
    {
        $conversation = \App\Conversation::where('title', Auth::user()->id . '-' . $id)->orWhere('title', $id . '-' . Auth::user()->id)->get(['id'])->first();
        if ($conversation == null)
            return null;
        else
            return $conversation;
    }

    public function loadMessages($id)
    {
        $conversation_id = $this->getConversation($id)->id;
        $messages = \App\Message::where('conversation_id', $conversation_id)->get();
        return $messages;
    }

    public function getConversationId($conversation)
    {
        if ($conversation == null) return 0;
        return $conversation->id;
    }

    public function insertMessage($id, $data)
    {
        $conversation_id = $this->getConversation($id)->id;
        $message = new \App\Message();
        $message->sender_id = Auth::user()->id;
        $message->message_type = $data['message_type'];
        $message->message = $data['message'];
        $conversation = \App\Conversation::find($conversation_id);
        $conversation->messages()->save($message);
    }
}