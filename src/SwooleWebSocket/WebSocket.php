<?php

namespace Jtrw\Micro\Poc\Rpc\SwooleWebSocket;

use Swoole\WebSocket\Server;

class WebSocket
{
    protected $webSocket;
    
    public function __construct()
    {
        $this->webSocket = new Server('0.0.0.0', 9502);
    }
    public function start()
    {
        $this->webSocket->on(
            'message',
            function (Swoole\WebSocket\Server $ws, Swoole\WebSocket\Frame $frame) {
                $ws->push($frame->fd, "Hello, {$frame->data}");
            }
        );
        $this->webSocket->start();
    }
}