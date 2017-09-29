<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Thread;
use App\Filters\ThreadFilters;

class ThreadController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')->except(['index', 'show']);
    }

    public function index(ThreadFilters $filters)
    {
        // $threads = $this->getThreads($filters);

        $threads = Thread::with('onwer')->latest()->filter($filters);

        // if ($channel->exists) {
        //     $threads->where('channel_id', $channel->id);
        // }
        // return $threads->paginate(25);
        $threads = $threads->get();

        return view('threads.index', compact('threads'));
    }

    public function show(Thread $thread)
    {
        $thread = $thread->load('onwer', 'replies', 'replies.onwer');
        $thread->increment('views_count');
        return view('threads.show', compact('thread'));
    }

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
            'replies_count' => 0,
            'views_count' => 0,
        ]);

        if (request()->wantsJson()) {
            return response($thread, 201);
        }

        return redirect()->route('threads.show', ['thread' => $thread->id]);
    }

    public function create()
    {
        return view('threads.create');
    }
}
