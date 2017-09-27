<?php

namespace App\Http\Controllers;

use App\Models\Thread;
use Illuminate\Http\Request;

class ReplyController extends Controller
{
    public function store(Request $request, Thread $thread)
    {
        $request->validate([
            'body' => 'required',
        ]);

        $reply = $thread->addReply([
            'user_id' => auth()->id(),
            'body' => $request->body,
        ]);

        if ($request->expectsJson()) {
            return response()->json($reply->load('onwer'), 201);
        }
    }
}
