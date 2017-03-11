<?php

namespace App\Http\Controllers;

use Session;
use Illuminate\Support\Facades\Input;
use Log;
use Auth;
use App\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function test(Request $request)
    {
//        Session::put("name","gavin");
//        Session(["name"=>"ghcgchc"]);
//        session(["name"=>"balabala"]);
//        dd(Session::getId());
//        Session::put("ddd","sss");
//        Session::forget('ddd');
//        $request->session()->regenerate();
//        session(['key1234' => 'value']);
        dd($request->session()->all());

    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = [
            'avatar' => '/images/avatar/default.png',
            'confirm_code' => str_random(48),
        ];
        $user = User::create(array_merge($request->get('user'), $data));
        return json_encode(["user_id" => $user->id, "status" => "success"]);
    }

    //登录验证
    public function loginValidation()
    {
        $email = Input::get("email");
        $pwd = Input::get("pwd");
        if(Auth::attempt([
            'email'=>$email,
            'password'=>$pwd
        ])){
            return response()->json(true);
        }
        return response()->json(false);
    }

    //用户登录
    public function login(Request $request)
    {
        $data = $request->get('user');
        \Log::info($data["email"]);
        $user = User::where("email", $data["email"])->first();
        session(["aaa"=>"bbb"]);
        \Log::info(session('aaa'));
        return json_encode(["user" => $user, "status" => true]);
    }

    //检查用户是否已经登录
    public function isLogin(Request $request)
    {
        $email = Input::get("email");
        $res =  $request->session()->has($email);
        if($res){
            return response()->json(true);
        }
        return response()->json(false);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\User $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\User $user
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \App\User $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\User $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        //
    }
}
