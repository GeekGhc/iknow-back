<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    protected $fillable = [
        'body','html_body','user_id', 'last_user_id', 'comment_count','vote_count','is_first'
    ];

    //帖子----用户
    public function user()
    {
        return $this->belongsTo('App\User');//$post->user()
    }

    //帖子----最后更新用户
    public function last_user()
    {
        return $this->belongsTo('App\User');
    }


}
