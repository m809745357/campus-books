<?php

namespace App\Http\Controllers;

use App\Models\Thread;
use App\Models\Reply;
use App\Models\Channel;
use Illuminate\Http\Request;

class ReplyController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function store(Request $request, Channel $channel, Thread $thread)
    {
        $request->validate([
            'body' => 'required',
        ]);

        $reply = $thread->addReply($request->body);

        if ($request->expectsJson()) {
            return response()->json($reply->load('onwer'), 201);
        }
    }

    public function destory(Reply $reply)
    {
        $this->authorize('delete', $reply);

        $reply->delete();
    }
}
