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
    Route::post('/register',function(Request $request){
        $data = $request->get('user');
        return json_encode(["name"=>"gehuachun","title"=>"first post"]);
    });
});