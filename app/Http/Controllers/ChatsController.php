<?php

namespace App\Http\Controllers;

use App\Models\Message;
use Illuminate\Http\Request;
use App\Events\MessageSent;

class ChatsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function index()
    {
        return view('chats');
    }
    public function fetchMessages()
    {
        return Message::with('user')->get();
    }
    public function sendMessages(Request $request)
    {
        $message = auth()->user()->messages()->create([
            'message' => $request->message
        ]);
            broadcast(new MessageSent($message->load('user')))->toOthers();
        return ['status' => 'success'];
    }
}
