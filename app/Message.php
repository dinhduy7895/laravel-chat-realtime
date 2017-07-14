<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    protected $table = 'messages';
    public $timestamps = false;

    public function user()
    {
        return $this->belongsTo('App\User','sender_id');
    }

    public function conversation()
    {
        return $this->belongsTo('App\Conversation', 'conversation_id');
    }

    public function participant()
    {
        return $this->belongsTo('App\Participant', 'participants_id');
    }
}
