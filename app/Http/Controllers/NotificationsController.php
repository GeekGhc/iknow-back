<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;

class NotificationsController extends Controller
{
    //用户未读消息的个数
    public function getNotificationCount($userId)
    {
        $count = User::find($userId)->unReadNotifications->count();
        return json_encode(["count" => $count, "status" => true]);
    }

    //用户消息
    public function getMessages($userId)
    {
        $user = User::find($userId);
        return json_encode(["messages" => $user->notifications, "status" => true]);
    }

    //标记全部消息为已读
    public function read($userId)
    {
        $user = User::find($userId);
        $user->unreadNotifications->markAsRead();
        return json_encode(["status" => true]);
    }
}
