<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Notifications\DatabaseNotification;
use App\User;

class ChatController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(User $user)
    {
        $notifications = DatabaseNotification::whereIn('notifiable_id', [auth()->id(), $user->id])->orderBy('created_at', 'asc')->get();
        return view('chats.index', compact('notifications', 'user'));
    }

    public function store(Request $request, User $user)
    {
        if (auth()->id() === $user->id) {
            return response(403);
        }

        $request->validate([
            'message' => 'required',
        ]);

        return $user->messages()->create([
            'from_user_id' => auth()->id(),
            'message' => $request->message
        ]);
    }
}
