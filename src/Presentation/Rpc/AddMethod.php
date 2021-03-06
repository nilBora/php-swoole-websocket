<?php

namespace Jtrw\Micro\Poc\Rpc\Presentation\Rpc;

use Jtrw\Micro\Poc\Rpc\Application\Dto\ItemDto;
use Jtrw\Micro\Poc\Rpc\Domain\Factory\CommandFactory;
use League\Tactician\CommandBus;
use Yoanm\JsonRpcServer\Domain\JsonRpcMethodInterface;

class AddMethod implements JsonRpcMethodInterface
{
    /**
     * CommandBus object.
     */
    private CommandBus $commandBus;
    
    /**
     * Command factory.
     */
    private CommandFactory $commandFactory;
    
    /**
     * FetchMethod constructor.
     */
    public function __construct(CommandBus $commandBus, CommandFactory $commandFactory)
    {
        $this->commandBus = $commandBus;
        $this->commandFactory = $commandFactory;
    }
    public function apply(array $paramList = null)
    {
        if (null === $paramList) {
            return null;
        }
        $itemDto = ItemDto::denormalize($paramList);

        return $this->commandBus->handle($this->commandFactory->makeItemRegisterTaskCommand($itemDto));
    }
}