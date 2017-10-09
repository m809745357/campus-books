<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Filters\FavoriteFilters;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        return view('users.index');
    }

    public function favorites(FavoriteFilters $filters)
    {
        $favorites = auth()->user()->favorited($filters);
        return view('users.favorites', compact('favorites'));
    }

    public function threads()
    {
        $threads = auth()->user()->threads()->with('onwer', 'channel')->latest()->get();

        return view('users.threads', compact('threads'));
    }

    public function replies()
    {
        $replies = auth()->user()->replies()->with('onwer', 'thread', 'thread.channel')->latest()->get();

        return view('users.replies', compact('replies'));
    }
}
