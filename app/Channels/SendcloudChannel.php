<?php
/**
 * Created by PhpStorm.
 * User: SUN
 * Date: 2021/8/1
 * Time: 3:42
 */
namespace App\Channels;

use Illuminate\Notifications\Notification;

/**
 * 自定义channels
 */
class SendcloudChannel
{
    public function send($notifiable, Notification $notification)
    {
        $message = $notification->toSendcloud($notifiable,$notification);
    }
    
}