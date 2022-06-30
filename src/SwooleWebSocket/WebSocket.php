<?php

namespace Jtrw\Micro\Poc\Rpc\SwooleWebSocket;

use Swoole\WebSocket\Server;
use Swoole\WebSocket\Frame;

class WebSocket
{
    protected Server $webSocket;
    
    public function __construct()
    {
        $this->webSocket = new Server('0.0.0.0', 9502);
    }
    public function start()
    {
        $this->webSocket->on(
            'message',
            function (Server $ws, Frame $frame) {
                $data = json_decode($frame->data, true, JSON_THROW_ON_ERROR);

                $instance = $this->getControllerInstance($data);
                $responseDto = $instance->apply($data['data']);
                
                $ws->push($frame->fd, $responseDto->toJson());
            }
        );
        $this->webSocket->start();
    }
    
    protected function getControllerInstance(array $data): WebsocketJsonRpcMethodInterface
    {
        $method = $this->getMethod($data);
        
        $namespace = "Jtrw\Micro\Poc\Rpc\Presentation\Socket\\".$method;
        return new $namespace();
    }
    
    protected function getMethod(array $data): string
    {
        $method = $data['method'] ?? null;
        if (!$method) {
            throw new \Exception("Must Me Method in RPC");
        }
        
        return $data['method'];
    }
}