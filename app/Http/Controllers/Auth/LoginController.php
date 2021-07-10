<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;


use Illuminate\Support\Str;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/home';
    //protected $redirectTo = '/';
    
    /**
     * redirectTo 方法优先于 redirectTo 属性。
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    protected function redirectTo()
    {
        $value = session('redirectTo');
        if ($value){
            session(['redirectTo' => '']);
            return $value;
        }
        return '/';
    }
    
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }
    
    /**
     *  重写方法
     */
    public function login(Request $request)
    {
        $this->validateLogin($request);
        
        // If the class is using the ThrottlesLogins trait, we can automatically throttle
        // the login attempts for this application. We'll key this by the username and
        // the IP address of the client making these requests into this application.
        if (method_exists($this, 'hasTooManyLoginAttempts') &&
          $this->hasTooManyLoginAttempts($request)) {
            $this->fireLockoutEvent($request);
           
            return $this->sendLockoutResponse($request);
        }
        
        if ($this->attemptLogin($request)) {
            //flash('欢迎回来','success');
            //flash('欢迎回来')->important();
            //flash('欢迎回来')->success();
            flash('欢迎回来')->overlay();
            return $this->sendLoginResponse($request);
        }
        
        // If the login attempt was unsuccessful we will increment the number of attempts
        // to login and redirect the user back to the login form. Of course, when this
        // user surpasses their maximum number of attempts they will get locked out.
        $this->incrementLoginAttempts($request);
        
        return $this->sendFailedLoginResponse($request);
    }
    
    /**
     * 重写登录验证方法
     * activated 必须为1 才能登录
     */
    protected function attemptLogin(Request $request)
    {
        $credentials = array_merge($this->credentials($request),['activated'=>1]);
        return $this->guard()->attempt(
          $credentials, $request->filled('remember')
        );
    }
}
