<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\ChatMessage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ChatController extends Controller
{
    public function SendMsg(Request $request)
    {
        $request->validate([
            'msg' => 'required'
        ]);

        ChatMessage::create([
            'sender_id' => Auth::user()->id,
            'receiver_id' => $request->receiver_id,
            'msg' => $request->msg,
        ]);

        return response()->json(['message' => 'Message Send Successful']);

    }

    public function GetAllUsers()
    {

        $chats = ChatMessage::orderBy('id', 'DESC')
            ->where('sender_id', auth()->id())
            ->orWhere('receiver_id', auth()->id())
            ->get();

        $users = $chats->flatMap(function ($chat) {

            if ($chat->sender_id === auth()->id()) {
                return [$chat->sender, $chat->receiver];
            }

            return [$chat->receiver, $chat->sender];

        })->unique();

        return $users;

    }
}
