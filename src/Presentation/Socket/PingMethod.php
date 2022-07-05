<?php
declare(strict_types=1);

namespace Jtrw\Micro\Poc\Rpc\Presentation\Socket;

use Jtrw\Micro\Poc\Rpc\SwooleWebSocket\Dto\ResponseDto;
use Jtrw\Micro\Poc\Rpc\SwooleWebSocket\WebsocketJsonRpcMethodInterface;

class PingMethod implements WebsocketJsonRpcMethodInterface
{
    
    public function apply(?array $paramList = null): ResponseDto
    {
        return new ResponseDto(["PONG"]);
    }
}