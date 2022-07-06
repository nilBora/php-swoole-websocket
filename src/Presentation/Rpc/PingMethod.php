<?php

declare(strict_types=1);

namespace Jtrw\Micro\Poc\Rpc\Presentation\Rpc;

use Jtrw\Micro\Poc\Rpc\Domain\Factory\CommandFactory;
use League\Tactician\CommandBus;
use Yoanm\JsonRpcServer\Domain\JsonRpcMethodInterface;

/**
 * Class PingMethod.
 */
class PingMethod implements JsonRpcMethodInterface
{
    private CommandBus $commandBus;
    
    private CommandFactory $commandFactory;
    
    public function __construct(CommandBus $commandBus, CommandFactory $commandFactory)
    {
        $this->commandBus = $commandBus;
        $this->commandFactory = $commandFactory;
    }
    /**
     * RPC api method health check ping.
     *
     * @param mixed[]|null $paramList
     *
     * @return mixed|string
     *
     * @suppress PhanUnusedPublicMethodParameter
     */
    public function apply(?array $paramList = null)
    {
        return $this->commandBus->handle(
            $this->commandFactory->makePingCommand()
        );
    }
}
