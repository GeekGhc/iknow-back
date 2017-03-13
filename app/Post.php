<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    protected $fillable = [
        'title', 'body',  'user_id', 'last_user_id', 'comment_count','is_first'
    ];

    //帖子----用户
    public function user()
    {
        return $this->belongsTo('App\User');//$discussion->user()
    }

    //帖子----最后更新用户
    public function last_user()
    {
        return $this->belongsTo('App\User');
    }


}
