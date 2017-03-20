<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    protected $fillable = ['post_id','user_id','to_user_id','to_comment_id','body'];

    //评论----用户
    public function user()
    {
        return $this->belongsTo('App\User');//$comment->user
    }

    //评论---回复用户
    public function toUser()
    {
        return $this->belongsTo(User::class,'to_user_id');
    }

    //评论----帖子
    public function post()
    {
        return $this->belongsTo(Post::class);//$comment->post
    }
}
