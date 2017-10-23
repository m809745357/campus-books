<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Thread;
use App\Models\Channel;
use App\Filters\ThreadFilters;
use App\User;

class ThreadController extends Controller
{
    /**
     * [__construct description]
     */
    public function __construct()
    {
        $this->middleware('auth')->except(['index', 'show']);
    }

    /**
     * 问答首页
     *
     * @param  Channel       $channel
     * @param  ThreadFilters $filters
     * @return \Illuminate\Http\Response
     */
    public function index(Channel $channel, ThreadFilters $filters)
    {
        $threads = Thread::with('onwer', 'channel')->latest()->filter($filters);

        if ($channel->exists) {
            $threads->where('channel_id', $channel->id);
        }

        $threads = $threads->get();

        return view('threads.index', compact('threads'));
    }

    /**
     * 展示单个问答
     * @param  Channel $channel
     * @param  Thread  $thread
     * @return \Illuminate\Http\Response
     */
    public function show(Channel $channel, Thread $thread)
    {
        $thread = $thread->load('onwer', 'replies', 'replies.onwer');
        $thread->increment('views_count');
        return view('threads.show', compact('thread'));
    }

    /**
     * 创建问答
     * @param  Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'title' => 'required',
            'body' => 'required',
        ]);

        $thread = Thread::create([
            'user_id' => auth()->id(),
            'title' => request('title'),
            'body' => request('body'),
            'money' => request('money'),
            'channel_id' => request('channel_id'),
            'replies_count' => 0,
            'views_count' => 0,
        ]);

        if (request()->wantsJson()) {
            return response($thread, 201);
        }

        return redirect($thread->path());
    }

    /**
     * 创建页面
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $channels = Channel::all();
        return view('threads.create', compact('channels'));
    }
}
