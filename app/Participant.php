<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Participant extends Model
{
    protected $table = 'participants';

    public function user()
    {
        return $this->belongsTo('App\User','users_id');
    }

    public function conversation()
    {
        return $this->belongsTo('App\Conversation','conversation_id');
    }

    public function messages()
    {
        return $this->hasMany('App\Message','participants_id');
    }
}
