<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');



Route::get('/email/verify/{token}',[
  'as'=>'email.verify',
  'uses'=>'EmailController@verify'
]);
//首页重定义
Route::get('/','QuestionsController@index');
Route::resource('questions','QuestionsController',[
  'names'=>[
      'create'  =>'question.create',
      'show'    =>'question.show'
  ]
]);

Route::post('questions/{question}/answer','AnswerController@store');
Route::get('questions/{question}/follow','QuestionFollowController@follow');


Route::get('notifications','NotificationsController@index');

