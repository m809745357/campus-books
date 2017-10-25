<?php

namespace App\Listeners;

use App\Events\UserReceivedNewChatMessage;
use App\Notifications\UserChatNotifications;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class NotifyChatUsers
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  UserReceivedNewChatMessage  $event
     * @return void
     */
    public function handle(UserReceivedNewChatMessage $event)
    {
        $event->message->toUser->notify(new UserChatNotifications($event->message));
    }
}
