<?php
namespace App\Channels;

use Illuminate\Notifications\Notification;

class SmsChannel
{
    /**
     * 发送给定通知。
     *
     * @param  mixed  $notifiable
     * @param  \Illuminate\Notifications\Notification  $notification
     * @return void
     */
    public function send($notifiable, Notification $notification)
    {
        $message = $notification->toSms($notifiable);
    }
}
