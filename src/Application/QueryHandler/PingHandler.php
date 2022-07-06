<?php

namespace Jtrw\Micro\Poc\Rpc\Application\QueryHandler;

use Jtrw\Micro\Poc\Rpc\Domain\Query\PingCommand;

class PingHandler implements QueryHandlerInterface
{
    public function handle(PingCommand $command): ?array
    {
        return ["PONG"];
    }
}