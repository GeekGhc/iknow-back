<?php

namespace App\Http\Controllers;

use App\Notifications\UserFollowNotification;
use App\User;
use Illuminate\Http\Request;

class FollowController extends Controller
{

    //用户是否关注
    public function isFollow($userId,$followedId)
    {
        $followedUser = User::find($followedId);
        $followers = $followedUser->followers()->pluck('follower_id')->toArray();
        if(in_array($userId,$followers)){
            return response()->json(true);
        }
        return response()->json(false);
    }

    //用户关注
    public function follow(Request $request)
    {
        $user = User::find($request->get('userId'));
        $followedUser = User::find($request->get('followedId'));
        $follow = $user->followThisUser($request->get('followedId'));
        //如果是用户关注另一个用户
        if(count($follow['attached'])>0){
            $user->increment('followings_count');
            $followedUser->increment('followers_count');
            $followedUser->notify(new UserFollowNotification(['name'=>$user->name,'type'=>'follow']));
            return response()->json(['followed' => true,'status'=>true]);
        }
        $user->decrement('followings_count');
        $followedUser->decrement('followers_count');
        return json_encode(['followed' => false,'status'=>true]);
    }

    //用户的粉丝
    public function followers($userId)
    {
        $user = User::find($userId);
        $usersId = $user->followers->pluck('id');
        if(!$usersId->isEmpty()){
            $users = User::with('profile')->where('id',$usersId)->get();
        }else{
            $users =  null;
        }
        return json_encode(['followers' =>$users,'status'=>true]);
    }

    //用户关注的人
    public function following($userId)
    {
        $user = User::find($userId);
        $usersId = $user->following->pluck('id');
        if(!$usersId->isEmpty()){
            $users = User::with('profile')->where('id',$usersId)->get();
        }else{
            $users = null;
        }
        return json_encode(['following' =>$users,'status'=>true]);
    }
}
