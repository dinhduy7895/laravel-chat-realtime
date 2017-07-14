<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Request;
use Redis;

class chatController extends Controller {
    public function __construct()
    {
    }
    public function sendMessage(){
        $data = ['message' => Request::input('message'), 'user' => Request::input('user')];
        Redis::publish('test-channel', json_encode($data));
        return response()->json([]);
    }
}