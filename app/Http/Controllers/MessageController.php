<?php

namespace App\Http\Controllers;

use App\Events\MessageSent;
use App\Message;
use Illuminate\Http\Request;

class MessageController extends Controller
{
    public function get()
    {
        return Message::with('user')->get();
    }

    public function send(Request $request)
    {
        $type = $request->message['type'];
        $message = $request->message['data'][$type];

        $message = auth()->user()->messages()->create([
            'type' => $type,
            'message' => $message,
        ]);

        broadcast(new MessageSent($message->load('user')))->toOthers();

        return ['status' => 'success'];
    }
}
