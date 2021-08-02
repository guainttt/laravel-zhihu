<?php
/**
 * Created by PhpStorm.
 * User: SUN
 * Date: 2021/8/2
 * Time: 20:33
 */
namespace  app\Mailer;
use Illuminate\Support\Facades\Auth;

class UserMailer extends Mailer
{
    public function followNotifyEmail($email)
    {
        $data = [
          'url' => url(config('app.url')),
          'name' => Auth::guard('api')->user()->name
        ];
        $this->sendTo('zhihu_app_new_user_follow',$email,$data);
    }
    
    public  function  passwordReset($email,$token)
    {
        $data = [
          'url'=>route('password.reset',['token'=>$token])
        ];
        $this->sendTo('zhihu_app_password_reset',$email,$data);
    }
    
    //https://www.sendcloud.net/email/#/sendAround/template
    public function welcome(User $user)
    {
        $data = [
          'url'=>route('email.verify',['token'=>$user->activation_token])
        ];
        $this->sendTo('test_template_active',$user->email,$data);
    }


}