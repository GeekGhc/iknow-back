<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;

class ValidateController extends Controller
{
    //验证用户名是否注册过
    public function ValidateName($name)
    {
        $res = User::where("name",$name)->count();
        if($res){
            return response()->json(false);
        }
        return response()->json(true);
    }

    //验证邮箱是否这测过
    public function ValidateEmail($email)
    {
        $res = User::where("email",$email)->count();
        if($res){
            return response()->json(false);
        }
        return response()->json(true);
    }
}
