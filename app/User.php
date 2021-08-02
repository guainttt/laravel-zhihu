<?php

namespace App;

use app\Mailer\UserMailer;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

use Illuminate\Support\Facades\Mail;
use Naux\Mail\SendCloudTemplate;
use App\Follow;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'avatar','activation_token','api_token'
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
     * 覆盖Notifiable里的代码  （忘记密码验证）
     * @param string $token
     */
    public function sendPasswordResetNotification($token)
    {
        //模板地址
        //https://www.sendcloud.net/email/#/sendAround/template
        /*$data = [
          'url'=>route('password.reset',['token'=>$token])
        ];
        //test_template 邮件模板
        $template = new SendCloudTemplate('zhihu_app_password_reset',$data);
        Mail::raw($template,function ($message){
            $message->from(env('SEND_CLOUD_FROM'),'知乎管理员');
            $message->to($this->email);
        });*/
        (new UserMailer())->passwordReset($this->email,$token);
    }
    
    public function owns(Model $model)
    {
        return $this->id == $model->user_id;
    }
    

    
   /* public function follows($question)
    {
        return Follow::create([
            'question_id'   =>$question,
            'user_id'       =>$this->id
        ]);
    }*/
   public function follows()
   {
       return $this->belongsToMany(Question::class,'user_question')
         ->withTimestamps();
   }
   public function followThis($question)
   {
       return $this->follows()->toggle($question);
   }
    
    public function followed($question)
    {
        return !! $this->follows()->where('question_id',$question)->count();
    }
    
    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    //关注的用户 绑定
    public function followersUser()
    {
        //1 类 2 表名 3 外键 4 外键
        return $this->belongsToMany(self::class, 'followers', 'followed_id', 'follower_id')
          ->withTimestamps();
    }
    
    //关注ta
    public function followThisUser($user)
    {
        return $this->followersUser()->toggle($user);
    }
}
