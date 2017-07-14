<?php

namespace App\Repositories\Conversation;

interface ConversationRepositoryInterface
{
    public function startToChat($id);
    public function getConversation($id);
    public function loadMessages($id);
    public function getConversationId($conversation);
    public function insertMessage($id, $data);
}