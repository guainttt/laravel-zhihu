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

Route::post('/question/follower',function (Request $request){
    //request('question')  或者这样获取
    $followed = !! \App\Follow::where('question_id',$request->get('question'))
                            ->where('user_id',$request->get('user'))
                            ->count();
    return response()->json(['followed'=>$followed]);
})->middleware('api');


Route::post('/question/follow',function (Request $request){
    //判断是否本人
    //,,,
    $followed =  \App\Follow::where('question_id',$request->get('question'))
      ->where('user_id',$request->get('user'))
      ->first();
    
    if ($followed !== null){
        $rs = $followed->delete();
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
    
    \App\Follow::create($attributes);
    return response()->json(['followed'=>true]);
})->middleware('api');