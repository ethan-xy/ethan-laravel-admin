<?php

namespace Ethan\LaravelAdmin\Http\Controllers;

use Ethan\LaravelAdmin\Models\AdminUser;
use Ethan\LaravelAdmin\Ethan\IM\Client;

class TestController extends Controller
{
    //发送系统通知
    public function sendNotification()
    {
        $data = [
            'action' => 'system',
            'info' => [
                'message' => '系统将维护!!!'
            ]
        ];

        $users = AdminUser::query()->limit(100)->get();
        foreach ($users as $user) {
            $user->notify(new \Ethan\LaravelAdmin\Notifications\Test($data));
        }

        (new Client())->sendMessageToUser($data);

        return response()->json();
    }
}