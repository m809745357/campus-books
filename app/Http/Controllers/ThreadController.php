<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Thread;

class ThreadController extends Controller
{
    public function index()
    {
        $threads = Thread::with('onwer')->latest()->get();

        return view('threads.index', compact('threads'));
    }

    public function show(Thread $thread)
    {
        $thread = $thread->load('onwer', 'replies', 'replies.onwer');
        $thread->increment('views_count');
        return view('threads.show', compact('thread'));
    }
}
