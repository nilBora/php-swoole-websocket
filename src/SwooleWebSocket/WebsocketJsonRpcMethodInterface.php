<?php

namespace Jtrw\Micro\Poc\Rpc\SwooleWebSocket;

use Jtrw\Micro\Poc\Rpc\SwooleWebSocket\Dto\ResponseDto;

interface WebsocketJsonRpcMethodInterface
{
    public function apply(?array $paramList = null): ResponseDto;
}