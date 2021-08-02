<?php
/**
 * Created by PhpStorm.
 * User: SUN
 * Date: 2021/8/2
 * Time: 18:23
 */
namespace App\Mailer;
use Naux\Mail\SendCloudTemplate;
use Illuminate\Support\Facades\Mail;

class Mailer
{
    
    /**
     * @param       $template 邮件模板
     * @param       $email    邮件地址
     * @param array $data    传递参数
     */
   public function sendTo($template,$email, array $data)
   {
       //模板地址
       //https://www.sendcloud.net/email/#/sendAround/template
       $content = new SendCloudTemplate($template,$data);
       Mail::raw($content,function ($message) use ($email){
           $message->from(env('SEND_CLOUD_FROM'),'知乎管理员');
           $message->to($email);
       });
   }
}