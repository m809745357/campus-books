<?php

namespace App\Http\Controllers;

use App\Models\Thread;
use App\Models\Channel;
use App\Models\Reply;
use App\User;
use App\Filters\FavoriteFilters;
use Illuminate\Http\Request;

class FavoriteController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(User $user, FavoriteFilters $filters)
    {
        $favorites = $user->favorited($filters);
        return view('users.favorites', compact('favorites'));
    }

    public function store(Reply $reply)
    {
        $reply->favorited();
    }

    public function destory(Reply $reply)
    {
        $reply->favorites->each->delete();
    }

    public function storeThreads(Channel $channel, Thread $thread)
    {
        $thread->favorited();
    }

    public function destoryThreads(Channel $channel, Thread $thread)
    {
        $thread->favorites->each->delete();
    }
}
