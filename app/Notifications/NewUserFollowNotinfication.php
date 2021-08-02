<?php

namespace App\Notifications;


use app\Mailer\UserMailer;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Support\Facades\Auth;

use App\Channels\SendcloudChannel;






class NewUserFollowNotinfication extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        //        return ['mail'];   //邮件通知
        return ['database',SendcloudChannel::class]; //站内信
    }                      
    
    
    
    
  
    
    public function toSendcloud($notifiable)
    {
        //模板地址
        //https://www.sendcloud.net/email/#/sendAround/template
        /*$data = [
          'url' => url(config('app.url')),
          'name' => Auth::guard('api')->user()->name
        ];
        
        //test_template 邮件模板
        $template = new SendCloudTemplate('zhihu_app_new_user_follow',$data);
        Mail::raw($template,function ($message) use ($notifiable){
            $message->from(env('SEND_CLOUD_FROM'),'知乎管理员');
            $message->to($notifiable->email);
        });*/
        (new UserMailer())->sendTo($notifiable->email);
        
    }
    
    public function toDatabase($notifiable)
    {
        return [
          'name'=> Auth::guard('api')->user()->name,
        
        ];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
                    ->line('The introduction to the notification.')
                    ->action('Notification Action', url('/'))
                    ->line('Thank you for using our application!');
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
