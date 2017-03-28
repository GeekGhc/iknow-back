<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    protected $fillable = [
        'name', 'email', 'avatar', 'password', 'confirm_code', 'is_confirmed', 'followers_count', 'followings_count'
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];

    //在数据保存到数据库之前会对密码进行一个预处理
    public function setPasswordAttribute($password)
    {
        $this->attributes['password'] = \Hash::make($password);
    }

    //用户----帖子
    public function posts()
    {
        return $this->hasMany(Post::class);//$user->posts
    }

    //用户----评论
    public function comments()
    {
        return $this->hasMany(Comment::class);//$user->comments
    }

    //用户----帖子(收藏)
    public function collect()
    {
        return $this->belongsToMany(Post::class,'collects')->withTimestamps();
    }

    //收藏帖子
    public function collectThis($post)
    {
        $this->collect()->toggle($post);
    }

    //用户---点赞
    public function like()
    {
        return $this->belongsToMany(Post::class,'likes')->withTimestamps();
    }

    //给帖子点赞
    public function likeThis($post)
    {
        $this->like()->toggle($post);
    }

    //用户---消息
    public function messages()
    {
        return $this->hasMany(Message::class,'to_user_id');
    }
}
