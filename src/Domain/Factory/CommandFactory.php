<?php

namespace Jtrw\Micro\Poc\Rpc\Domain\Factory;

use Jtrw\Micro\Poc\Rpc\Application\Dto\ItemDto;
use Jtrw\Micro\Poc\Rpc\Domain\Command\ItemCreateTaskCommand;
use Jtrw\Micro\Poc\Rpc\Domain\Query\PingCommand;
use Jtrw\Micro\Poc\Rpc\Domain\ValueObject\Item;
use MicroModule\Base\Domain\Command\CommandInterface;
use MicroModule\Base\Domain\Exception\FactoryException;
use MicroModule\Base\Domain\Factory\CommandFactoryInterface;
use MicroModule\ValueObject\Identity\UUID as ProcessUuid;

class CommandFactory implements CommandFactoryInterface
{
    public const PING_COMMAND               = 'PingCommand';
    public const ITEM_REGISTER_TASK_COMMAND = 'ItemRegisterTaskCommand';
    
    public function makeCommandInstanceByType(...$args): CommandInterface
    {
        $commandType = array_shift($args);
    
        switch ($commandType) {
            case self::PING_COMMAND:
                return $this->makePingCommand(...$args);
            case self::ITEM_REGISTER_TASK_COMMAND:
                return $this->makeItemRegisterTaskCommand(...$args);
        
            default:
                throw new FactoryException(sprintf('Command bus for type `%s` not found!', (string) $commandType));
        }
    }
    
    public function makePingCommand(): PingCommand
    {
        return new PingCommand();
    }
    
    public function makeItemRegisterTaskCommand(ItemDto $itemDto): ItemCreateTaskCommand
    {
        $uuid = ProcessUuid::fromNative(null);
        $item = Item::fromNative($itemDto->normalize());

        return new ItemCreateTaskCommand($uuid, $item);
    }
}