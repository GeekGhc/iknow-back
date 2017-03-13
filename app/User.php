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
    public function discussions()
    {
        return $this->hasMany(Post::class);//$user->discussions()
    }
}
