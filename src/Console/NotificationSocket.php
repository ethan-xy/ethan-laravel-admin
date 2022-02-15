<?php

namespace Ethan\LaravelAdmin\Console;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Redis;
use Laravel\Sanctum\Sanctum;

class NotificationSocket extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'swoole-socket:start';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '消息推送启动命令';

    protected $server;

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $this->server = new \swoole_websocket_server('0.0.0.0', 9502);
        //监听WebSocket连接打开事件
        $this->server->on('open', function ($server, $request) {
            $model = Sanctum::$personalAccessTokenModel;
            $accessToken = $model::findToken($request->get['token']);

            if (!$accessToken) {
                $server->close($request->fd);
                return false;
            }

            $user = $accessToken->tokenable->withAccessToken(
                tap($accessToken->forceFill(['last_used_at' => now()]))->save()
            );

            //未登录，结束会话
            if (!$user) {
                $server->close($request->fd, $user);
                return false;
            }

            //redis有序集合
            Redis::zadd('swoole-start', $request->fd, data_get($user, 'id', 0));
        });

        //监听WebSocket消息事件
        $this->server->on('message', function ($server, $frame) {
//            $frame->opcode = WEBSOCKET_OPCODE_PING;
//            $server->push($frame->fd, $frame);
//            $data = json_decode($frame->data, true);
        });


        $this->server->on('request', function ($request, $response) {
            //redis有序集合指定区间内的成员(全部)
            $connectionsData = Redis::zrange("swoole-start", 0, -1, array('withscores' => true));
            switch ($request->post['action']) {
                case 'system':
                    foreach ($connectionsData as $k => $v) {
                        if ($this->server->isEstablished(intval($v))) {
                            $this->server->push(intval($v), json_encode($request->post, true));
                        }
                    }
                    break;
                default:
            }

            $response->end('ok');
        });

        //监听WebSocket连接关闭事件
        $this->server->on('close', function ($server, $fd) {
            //redis移除有序集合中给定的分数区间的成员
            Redis::zremrangebyscore('swoole-start', $fd, $fd);
            echo "client-{$fd} is closed\n";
        });

        $this->server->start();
    }
}