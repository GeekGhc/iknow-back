<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    protected $fillable = ['post_id','user_id','to_user_id','to_comment_id','body'];

    //评论----帖子
    public function post()
    {
        return $this->belongsTo('App\Post');//$comment->post
    }
}
