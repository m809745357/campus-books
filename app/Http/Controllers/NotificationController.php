<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class NotificationController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        foreach (auth()->user()->contacts->load('person')->sortBy('created_at')->values() as $notify) {
            $notifications[] = array(
                'id' => $notify->person->id,
                'nickname' => $notify->person->nickname,
                'avatar' => $notify->person->avatar,
                'message' => $notify->person->messages()->latest()->first()->message,
                'created_at' => \Carbon\Carbon::parse($notify->person->messages->first()->created_at)->diffForHumans(),
                'count' => $notify->notifies_count
            );
        }
        $notifications = json_encode($notifications);

        return view('users.notifications', compact('notifications'));
    }
}
