<?php

namespace Jtrw\Micro\Poc\Rpc\SwooleWebSocket;

use Jtrw\Micro\Poc\Rpc\SwooleWebSocket\Exception\RpcMethodNotFoundException;
use Jtrw\Micro\Poc\Rpc\SwooleWebSocket\Utils\CliUtils;
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
    
    protected string $host;
    protected int $port;
    
    public function __construct(array $options)
    {
        $this->host = $options['host'] ?? '';
        $this->port = $options['port'] ?? '';
        $this->server = new Server($this->host, $this->port);
    
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
            static::MESSAGE_HANDLER,
            function (Server $server, Frame $frame) {
                $data = json_decode($frame->data, true, JSON_THROW_ON_ERROR);
                
                $instance = $this->getControllerInstance($data);
                $responseDto = $instance->apply($data['params']);
    
                $server->push($frame->fd, $responseDto->toJson());
            }
        );
    }
    
    protected function openHandler()
    {
        $this->server->on(static::OPEN_HANDLER, function (Server $server, Request $request) {
            CliUtils::s("connection open: {$request->fd}");
            
            $server->tick(1000, function () use ($server, $request) {
                $server->push($request->fd, json_encode(["hello", time()]));
            });
        });
    }
    
    protected function closeHandler()
    {
        $this->server->on(static::CLOSE_HANDLER, function (Server $server, int $fd) {
            CliUtils::s("connection close: {$fd}");
        });
    }
    
    protected function startHundler(): void
    {
        $this->server->on(static::START_HANDLER, function (Server $server) {
            $msg = sprintf("Swoole WebSocket Server started at %s:%s", $this->host, $this->port);
            CliUtils::s($msg);
        });
    }
    
    protected function getControllerInstance(array $data): WebsocketJsonRpcMethodInterface
    {
        $method = $this->getMethod($data);
        
        $namespace = "Jtrw\Micro\Poc\Rpc\Presentation\Socket\\".$method."Method";
        return new $namespace();
    }
    
    protected function getMethod(array $data): string
    {
        $method = $data['method'] ?? null;
        if (!$method) {
            throw new RpcMethodNotFoundException("Must Me Method in RPC");
        }
        
        return $data['method'];
    }
}