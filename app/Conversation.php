<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Conversation extends Model
{
    protected $table = 'conversation';

    public function user()
    {
        return $this->belongsTo('App\User', 'creator_id');
    }

    public function participants()
    {
        return $this->hasMany('App\Participant', 'conversation_id');
    }

    public function messages()
    {
        return $this->hasMany('App\Message', 'conversation_id');
    }

}
