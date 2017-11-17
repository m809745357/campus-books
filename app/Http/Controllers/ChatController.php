<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Notifications\DatabaseNotification;
use App\User;
use App\Models\Contact;

class ChatController extends Controller
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
     * @param  User   $user [description]
     * @return [type]       [description]
     */
    public function index(User $user)
    {
        auth()->user()->addContacts($user);

        $user->addContacts(auth()->user());

        auth()->user()->sayHello($user);

        auth()->user()->markAsRead();

        $notifications = auth()->user()->notifications
                            ->where('data.from_user_id', $user->id)
                            ->merge(
                                $user->notifications->where('data.from_user_id', auth()->id())
                            )
                            ->sortBy('created_at')
                            ->values();

        return view('chats.index', compact('notifications', 'user'));
    }

    /**
     * 新增消息
     *
     * @param  Request $request [description]
     * @param  User    $user    [description]
     * @return Illuminate\Http\Response
     */
    public function store(Request $request, User $user)
    {
        if (auth()->id() === $user->id) {
            return response(403);
        }

        $request->validate([
            'message' => 'required',
        ]);

        return $user->addMessage($request->message);
    }
}
