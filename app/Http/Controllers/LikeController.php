<?php

namespace App\Http\Controllers;

use App\Like;
use App\Notifications\QuestionLikeNotification;
use App\Post;
use App\User;
use Illuminate\Http\Request;

class LikeController extends Controller
{
    //用户点赞帖子
    public function store(Request $request)
    {
        $userId = $request->get('userId');
        $postId = $request->get('postId');
        $user = User::find($userId);
        $post = Post::find($postId);
        $like= $user->likeThis($postId);
        $count = Like::where(['user_id'=>$userId,'post_id'=>$postId])->count();
        if($count>0){//用户赞了这篇帖子
            $post->increment('vote_count');
            $data = ['name'=>$user->name,'title'=>$post->body,'id'=>$post->id,'type'=>'like'];
            $post->user->notify(new QuestionLikeNotification($data));
            return json_encode(["isVoted" => true, "status" => "true"]);
        }else{
            $post->decrement('vote_count');
            return json_encode(["isVoted" => false, "status" => "true"]);
        }

    }

    //用户是否已经赞了这篇帖子
    public function hasLiked($userId,$postId)
    {
        $status = Like::where(['user_id'=>$userId,'post_id'=>$postId])->count();
        if($status){
            return response()->json(true);
        }
        return response()->json(false);
    }
}
