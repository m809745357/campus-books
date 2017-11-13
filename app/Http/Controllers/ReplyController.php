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

    /**
     * 打赏
     *
     * @param  Reply  $reply [description]
     * @return \Illuminate\Http\Response
     */
    public function best(Reply $reply)
    {
        $this->authorize('best', $reply);

        if (! $reply->isBeenReward()) {
            return response('已经打赏过一个用户', 400);
        }

        if (! $reply->ifHasEnoughMoney()) {
            return response('没有足够的余额支付，请充值', 400);
        }

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
