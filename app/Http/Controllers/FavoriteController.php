<?php

namespace App\Http\Controllers;

use App\Models\Thread;
use App\Models\Channel;
use App\Models\Reply;
use App\User;
use Illuminate\Http\Request;

class FavoriteController extends Controller
{
    /**
     * [__construct description]
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * 创建
     *
     * @param  Reply  $reply
     * @return \Illuminate\Http\Response
     */
    public function store(Reply $reply)
    {
        $reply->favorited();
    }

    /**
     * 删除
     *
     * @param  Reply  $reply
     * @return \Illuminate\Http\Response
     */
    public function destory(Reply $reply)
    {
        $reply->favorites->each->delete();
    }

    /**
     * 创建
     *
     * @param  Channel  $channel
     * @param  Thread   $thread
     * @return \Illuminate\Http\Response
     */
    public function storeThreads(Channel $channel, Thread $thread)
    {
        $thread->favorited();
    }

    /**
     * 删除
     *
     * @param  Channel  $channel
     * @param  Thread   $thread
     * @return \Illuminate\Http\Response
     */
    public function destoryThreads(Channel $channel, Thread $thread)
    {
        $thread->favorites->each->delete();
    }
}
