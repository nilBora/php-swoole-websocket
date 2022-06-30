<?php

namespace Jtrw\Micro\Poc\Rpc\SwooleWebSocket;

use Swoole\WebSocket\Server;
use Swoole\WebSocket\Frame;
use Swoole\Http\Request;

class WebSocket
{
    protected Server $server;
    
    public function __construct(array $options)
    {
        $host = $options['host'] ?? '';
        $port = $options['port'] ?? '';
        $this->server = new Server($host, $port);
    }
    public function start()
    {
        $this->server->on("Start", function(Server $server)
        {
            echo "Swoole WebSocket Server started at 127.0.0.1:9501\n";
        });
    
        $this->server->on('Open', function(Server $server, Request $request)
        {
            echo "connection open: {$request->fd}\n";
        
            $server->tick(1000, function() use ($server, $request)
            {
                $server->push($request->fd, json_encode(["hello", time()]));
            });
        });
        
        $this->server->on(
            'message',
            function (Server $ws, Frame $frame) {
                $data = json_decode($frame->data, true, JSON_THROW_ON_ERROR);

                $instance = $this->getControllerInstance($data);
                $responseDto = $instance->apply($data['params']);
                
                $ws->push($frame->fd, $responseDto->toJson());
            }
        );
    
        $this->server->on('Close', function(Server $server, int $fd)
        {
            echo "connection close: {$fd}\n";
        });
        
        $this->server->start();
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