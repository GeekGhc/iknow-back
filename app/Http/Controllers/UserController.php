<?php

namespace App\Http\Controllers;

use App\Post;
use App\Profile;
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
        $data = [
            'posts_count'=>45,
            'collect_count'=>56
        ];
        $user = User::find(6);
        $posts_count = $user->posts->count();
        $collect_count = $user->collect->count();
        return json_encode(['data'=>$data]);
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


   //注册用户
    public function store(Request $request)
    {
        $data = [
            'avatar' => '/static/images/avatar/default/my-avatar.jpg',
            'confirm_code' => str_random(48),
        ];
        $user = User::create(array_merge($request->get('user'), $data));
        $profile = Profile::create(['user_id'=>$user->id]);
        return json_encode(["user_id" => $user->id, "status" => "success"]);
    }

    //登录验证
    public function loginValidation(Request $request)
    {

    }

    //用户登录
    public function login(Request $request)
    {
        $data = $request->get('user');
        \Log::info($data);
        if(Auth::attempt([
            'email'=> $data['email'],
            'password'=>$data['password']
        ])){
            $user = User::where('email',$data['email'])->first();
            return json_encode(['user'=>$user,'status'=>true]);
        }
        return json_encode(['user'=>null,'status'=>false]);
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


    //用户的个人资料
    public function profile($userId)
    {
        $user = User::find($userId);
        $profile = Profile::where('user_id',$userId)->first();
        $data = array_merge(['name'=>$user->name],$profile->toArray());
        return json_encode(['profile'=>$data,'status'=>true]);

    }

    //更新用户的个人资料
    public function update(Request $request)
    {
        $data = $request->get('data');
        $userId = $request->get('userId');
        $user = User::find($userId);
        $user->name = $data['name'];
        $user->save();
        $res = Profile::where('user_id',$userId)->update([
            'phone'=>$data['phone'],
            'city'=>$data['city'],
            'site'=>$data['site'],
            'description'=>$data['description']
        ]);
        return json_encode(['user'=>$data['name'],'status'=>true]);
    }



    //用户的个人主页
    public function account($userId)
    {
        $user = User::find($userId);
        $showCount = [
            'posts_count'=>$user->posts->count(),
            'collect_count'=>$user->collect->count(),
            'followers_count'=>24,
            'following_count'=>99
        ];
        return json_encode(['user'=>$user,'showCount'=>$showCount,'status'=>true]);
    }

}
