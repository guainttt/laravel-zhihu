<?php

namespace App\Http\Controllers\Auth;

use app\Mailer\UserMailer;
use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;
//use Mail;

use Illuminate\Support\Facades\Mail;
use Naux\Mail\SendCloudTemplate;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function create(array $data)
    {
        $user = User::create([
          'name' => $data['name'],
          'email' => $data['email'],
          'avatar' => '/image/avatars/default.jpg',
            //这里其实不需要再设置activation_token的值，也不需要再在验证后设置activated=1 采用Laravel提供的新功能验证用户邮箱即可 默认带一个email_verified_at字段，且更加完善具有过期时间戳和签名
          'activation_token' => str_random(40),//通过composer require laravel/helpers安装扩展包
          'password' => Hash::make($data['password']),
           //添加token
           'api_token'=>str_random(60)
        ]);
        $this->sendVerifyEmailTo($user);
        return $user;
    }
    
    
    private function sendVerifyEmailTo($user)
    {
        //模板地址
        //https://www.sendcloud.net/email/#/sendAround/template
/*        $data = [
          'url'=>route('email.verify',['token'=>$user->activation_token])
          
        ];
        //test_template 邮件模板
        $template = new SendCloudTemplate('test_template_active',$data);
        Mail::raw($template,function ($message) use ($user){
            $message->from(env('SEND_CLOUD_FROM'),'知乎管理员');
            $message->to($user->email);
        });*/
        (new UserMailer())->welcome( $user);
    }
    

    
    
}
