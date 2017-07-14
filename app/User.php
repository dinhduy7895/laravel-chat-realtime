<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\Auth;
use  App\Participant;
use Illuminate\Support\Facades\DB;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $table = 'users';
    protected $fillable = [
        'username', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function getRouteKeyName()
    {
        return 'username';
    }

    public function conversations()
    {
        return $this->hasMany('App\Conversation', 'creator_id');
    }

    public function participants()
    {
        return $this->hasMany('App\Participant', 'users_id');
    }

    public function messages()
    {
        return $this->hasMany('App\Message', 'sender_id');
    }

   
}
