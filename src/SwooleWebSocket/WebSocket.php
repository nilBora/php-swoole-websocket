<?php

namespace Jtrw\Micro\Poc\Rpc\SwooleWebSocket;

use Swoole\WebSocket\Server;
use Swoole\WebSocket\Frame;
use Swoole\Http\Request;

class WebSocket
{
    protected Server $server;
    
    protected const OPEN_HANDLER    = "Open";
    protected const CLOSE_HANDLER   = "Close";
    protected const START_HANDLER   = "Start";
    protected const MESSAGE_HANDLER = "message";
    
    protected const SYSTEM_HANDLERS = [
        self::OPEN_HANDLER,
        self::CLOSE_HANDLER,
        self::START_HANDLER,
        self::MESSAGE_HANDLER
    ];
    
    public function __construct(array $options)
    {
        $host = $options['host'] ?? '';
        $port = $options['port'] ?? '';
        $this->server = new Server($host, $port);
    
        $this->init();
    }
    
    public function start()
    {
        $this->server->start();
    }
    
    protected function init()
    {
        foreach (static::SYSTEM_HANDLERS as $name) {
            $methodName = strtolower($name)."Handler";
            if (method_exists($this, $methodName)) {
                $this->$methodName();
            }
        }
    }
    
    protected function messageHandler()
    {
        $this->server->on(
            'message',
            function (Server $ws, Frame $frame) {
                $data = json_decode($frame->data, true, JSON_THROW_ON_ERROR);
                
                $instance = $this->getControllerInstance($data);
                $responseDto = $instance->apply($data['params']);
                
                $ws->push($frame->fd, $responseDto->toJson());
            }
        );
    }
    
    protected function openHandler()
    {
        $this->server->on('Open', function (Server $server, Request $request) {
            echo "connection open: {$request->fd}\n";
            
            $server->tick(1000, function () use ($server, $request) {
                $server->push($request->fd, json_encode(["hello", time()]));
            });
        });
    }
    
    protected function closeHandler()
    {
        $this->server->on('Close', function (Server $server, int $fd) {
            echo "connection close: {$fd}\n";
        });
    }
    
    protected function startHundler(): void
    {
        $this->server->on("Start", function (Server $server) {
            echo "Swoole WebSocket Server started at 127.0.0.1:9501\n";
        });
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