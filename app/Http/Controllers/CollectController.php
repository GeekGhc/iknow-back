<?php

namespace App\Http\Controllers;

use App\Collect;
use App\Post;
use App\User;
use Illuminate\Http\Request;

class CollectController extends Controller
{
    //用户收藏帖子
    public function store(Request $request)
    {
        $user = User::find($request->get("userId"));
        $collect = $user->collectThis($request->get("postId"));
        $post = Post::find($request->get('postId'));
        $data = ['name'=>$user->name,'title'=>$post->body,'id'=>$post->id,'type'=>'collect'];
        return json_encode(["isCollect" => true, "status" => "true"]);
    }

    //用户收藏帖子列表
    public function getCollectList($userId)
    {
        $user = User::find($userId);
        $collectionId = $user->collect->pluck('id');
        $collection = Post::with('user')->find($collectionId->toArray());
        return json_encode(["collection" => $collection, "status" => "true"]);
    }

    //用户是否已经收藏了该帖子
    public function hasCollected($userId,$postId)
    {
        $status = Collect::where(['user_id'=>$userId,'post_id'=>$postId])->count();
        if($status){
            return response()->json(true);
        }
        return response()->json(false);
    }
}
