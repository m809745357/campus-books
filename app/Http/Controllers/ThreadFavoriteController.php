<?php

namespace App\Http\Controllers;

use App\Models\Thread;
use App\Models\Channel;
use App\Models\Reply;
use App\User;
use Illuminate\Http\Request;

class ThreadFavoriteController extends Controller
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
     * @param  Channel  $channel
     * @param  Thread   $thread
     * @return \Illuminate\Http\Response
     */
    public function store(Channel $channel, Thread $thread)
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
    public function destory(Channel $channel, Thread $thread)
    {
        $thread->favorites->each->delete();
    }
}
