<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

use Illuminate\Support\Facades\Mail;
use Naux\Mail\SendCloudTemplate;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'avatar','activation_token'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
    
    /**
     * 覆盖Notifiable里的代码
     * @param string $token
     */
    public function sendPasswordResetNotification($token)
    {
        //模板地址
        //https://www.sendcloud.net/email/#/sendAround/template
        $data = [
          'url'=>route('password.reset',['token'=>$token])
        ];
        //test_template 邮件模板
        $template = new SendCloudTemplate('zhihu_app_password_reset',$data);
        Mail::raw($template,function ($message){
            $message->from(env('SEND_CLOUD_FROM'),'知乎管理员');
            $message->to($this->email);
        });
    }
}
