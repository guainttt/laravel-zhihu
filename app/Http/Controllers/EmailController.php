<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Illuminate\Support\Facades\Auth;

class EmailController extends Controller
{
    //
    public function verify($token)
    {
        $user = User::where('activation_token',$token)->first();
        if(is_null($user)){
            return redirect('/');
        }
        $user->activated = 1;
        $user->activation_token = str_random(40);
        $user->save();
        Auth::login($user);
        return redirect('/home');
    }
}
