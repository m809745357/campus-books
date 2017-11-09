<?php

namespace App\Http\Controllers;

use App\Models\Thread;
use App\Models\Reply;
use App\Models\Channel;
use Illuminate\Http\Request;

class ReplyController extends Controller
{
    /**
     * [__construct description]
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * 添加回复
     *
     * @param  Request $request
     * @param  Channel $channel
     * @param  Thread  $thread
     * @return \Illuminate\Http\Response
     */
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

    public function best(Reply $reply)
    {
        $reply->best();
    }

    /**
     * 删除回复
     *
     * @param  Reply  $reply
     * @return \Illuminate\Http\Response
     */
    public function destory(Reply $reply)
    {
        $this->authorize('delete', $reply);

        $reply->delete();
    }
}
