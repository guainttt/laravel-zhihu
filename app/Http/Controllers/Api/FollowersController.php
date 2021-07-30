<?php

namespace App\Http\Controllers\Api;

use App\Repositories\UserRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

use App\Notifications\NewUserFollowNotinfication;

class FollowersController extends Controller
{
    //
    protected $user;
    public function __construct(UserRepository $user)
    {
        $this->user = $user;
        $this->middleware('auth:api')->only('index','follow');
    }
    
    /**
     * 查看是否已关注
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index($id)
    {
       //被关注者
       $user = $this->user->byId($id);
       $followers = $user->followersUser()
         ->pluck('follower_id')->toArray();
       $uid = Auth::guard('api')->user()->id;
       if( in_array($uid,$followers)){
           return response()->json(['followed'=>true]);
       }
       return response()->json(['followed'=>false]);
    }
    
    public function follow()
    {
        $userToFollow = $this->user->byId(request('user'));
        
        $followed = Auth::guard('api')->user()->followThisUser($userToFollow->id);
        
        if (count($followed['attached']) > 0 ){
            $userToFollow->increment('followers_count');
            $userToFollow->notify(new NewUserFollowNotinfication());
            return response()->json(['followed'=>true]);
        }
        $userToFollow->decrement('followers_count');
        return response()->json(['followed'=>false]);
    }
}
