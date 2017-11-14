<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class NotificationController extends Controller
{
    /**
     * [__construct description]
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * 我的消息
     *
     * @return [type] [description]
     */
    public function index()
    {
        $notifications = auth()->user()->contact();

        return view('users.notifications', compact('notifications'));
    }
}
