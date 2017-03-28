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

//用户组路由
Route::group(['prefix'=>'user','middleware'=>['api','cors']], function () {
    Route::post('/register','UserController@store');//用户注册
//    Route::post('/login/validation','UserController@loginValidation');//用户登录字段数据检验
    Route::post('/login','UserController@login');//用户进行登录
    Route::get('/login/isLogin','UserController@isLogin');//判断用户是否已经登录

    Route::post('/{userId}/account','UserController@account');//用户的主页
    Route::get('/profile/{userId}','UserController@profile');//用户的个人资料
    Route::patch('/profile/update','UserController@update');//用户的个人资料更新
});

//用户验证路由
Route::group(['prefix'=>'unique','middleware'=>['api','cors']], function () {
    Route::get('/name/{value}','ValidateController@ValidateName');
    Route::get('/email/{value}','ValidateController@ValidateEmail');
});

//帖子组路由
Route::group(['middleware'=>['api','cors']], function () {
    Route::resource('/post','PostController');
});

//用户帖子路由
Route::group(['prefix'=>'user','middleware'=>['api','cors']], function () {
    Route::post('/post','PostController@userPost');//用户帖子
    Route::delete('/post/{postId}','PostController@userPostDelete');//用户删除帖子
});

//评论组路由
Route::group(['middleware'=>['api','cors']], function () {
    Route::post('/comment','CommentController@store');
    Route::get('/post/{postId}/comment','CommentController@postComments');
    Route::get('/comment/{commentId}','CommentController@index');
});

//用户收藏帖子组路由
Route::group(['middleware'=>['api','cors']], function () {
    Route::post('/post/collect','CollectController@store');//用户收藏帖子
    Route::get('/user/{userId}/collect','CollectController@getCollectList');//用户收藏的帖子列表
    Route::get('/user/{userId}/post/{postId}','CollectController@hasCollected');//用户是否已经收藏了该帖子
});

//用户点赞帖子组路由
Route::group(['middleware'=>['api','cors']], function () {
    Route::post('/user/post/like','LikeController@store');//用户点赞帖子
    Route::get('/user/{userId}/post/{postId}/like','LikeController@hasLiked');//用户是否已经攒了该帖子
});