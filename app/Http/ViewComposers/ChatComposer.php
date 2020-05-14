<?php

namespace App\Http\ViewComposers;

use App\Message;
use App\User;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class ChatComposer
{
    public $participants;
    public $messages;

    public function __construct()
    {
        $this->participants = $this->getParticipants();
        $this->messages = $this->getMessages();
    }

    public function getParticipants()
    {
        $me = auth()->user();
        $participants = User::select('id','name', 'avatar as imageUrl')->get();
        foreach ($participants as $item) {
            $item->imageUrl = Storage::url($item->imageUrl);
            if ($item->id == $me->id)
                $item->online = true;
            else
                $item->online = false;
        }
        return $participants;
    }

    public function getMessages()
    {
        $messages = Message::select('id', 'user_id as author', 'type', 'message')->get();
        foreach ($messages as $item) {
            $item->data = [$item->type => $item->message];
        }
        $messages->toJson();
        return $messages;
    }

    public function compose(View $view)
    {
        $view->with('participants', $this->participants);
        $view->with('messages', $this->messages);
    }
}