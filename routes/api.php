<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/topics',function (Request $request){
    $topics = \App\Topic::select(['id','name'])
      ->where('name','like','%'.$request->query('q').'%')
      ->get();
    return $topics;
});
Route::middleware('auth:api')->post('/question/follower',function (Request $request){
    //request('question')  或者这样获取
    /*$followed = !! \App\Follow::where('question_id',$request->get('question'))
                            ->where('user_id',$request->get('user'))
                            ->count();*/
    
    $user = Auth::guard('api')->user();
    $followed = $user->followed($request->get('question'));
    
    return response()->json(['followed'=>$followed]);
});


Route::post('/question/follow',function (Request $request){
    
    
    /*
    $followed =  \App\Follow::where('question_id',$request->get('question'))
      ->where('user_id',$request->get('user'))
      ->first();
    if ($followed !== null){
        $rs = $followed->delete();
        $question->decrement('followers_count');
        
        if ($rs){
            return response()->json(['followed'=>false]);
        }else{
            return response()->json(['error'=>'请稍后再试']);
        }
    }
    $attributes = [
      'question_id'=> $request->get('question'),
      'user_id'    => $request->get('user')
    ];
    
    \App\Follow::create($attributes);*/
    
    
    $user = Auth::guard('api')->user();
    $question = \App\Question::find($request->get('question'));
    $followed = $user->followThis($question->id);
    if (count($followed['detached'])>0){
        $question->decrement('followers_count');
        return response()->json(['followed'=>false]);
    }
    
    $question->increment('followers_count');
    return response()->json(['followed'=>true]);
})->middleware('auth:api');



// 用户关注用户接口
Route::get('/user/followers/{user}','Api\FollowersController@index');

Route::post('/user/follow','Api\FollowersController@follow');


// 点赞答案接口
Route::post('/answer/{id}/votes/users','Api\VotesController@users');

Route::post('/answer/vote','Api\VotesController@vote');

