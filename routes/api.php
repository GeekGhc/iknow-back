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
    Route::get('/login/validation','UserController@loginValidation');//用户登录字段数据检验
    Route::post('/login','UserController@login');//用户进行登录
    Route::get('/login/isLogin','UserController@isLogin');//判断用户是否已经登录
});

//用户验证路由
Route::group(['prefix'=>'unique','middleware'=>['api','cors']], function () {
    Route::get('/name/{value}','ValidateController@ValidateName');
    Route::get('/email/{value}','ValidateController@ValidateEmail');
});