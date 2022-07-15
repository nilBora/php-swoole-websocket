<?php

namespace Jtrw\Micro\Poc\Rpc\Domain\Factory;

use Jtrw\Micro\Poc\Rpc\Domain\Command\ItemCreateTaskCommand;
use Jtrw\Micro\Poc\Rpc\Domain\Query\PingCommand;
use Jtrw\Micro\Poc\Rpc\Domain\ValueObject\Item;
use MicroModule\Base\Domain\Command\CommandInterface;
use MicroModule\Base\Domain\Exception\FactoryException;
use MicroModule\Base\Domain\Factory\CommandFactoryInterface;
use MicroModule\ValueObject\Identity\UUID as ProcessUuid;

class CommandFactory implements CommandFactoryInterface
{
    public const PING_COMMAND = 'PingCommand';
    
    public function makeCommandInstanceByType(...$args): CommandInterface
    {
        $commandType = array_shift($args);
    
        switch ($commandType) {
            case self::PING_COMMAND:
                return $this->makePingCommand(...$args);
        
            default:
                throw new FactoryException(sprintf('Command bus for type `%s` not found!', (string) $commandType));
        }
    }
    
    public function makePingCommand(): PingCommand
    {
        return new PingCommand();
    }
    
    public function makeItemRegisterTaskCommand(UserDtoInterface $userDto): CommandInterface
    {
        $uuid = ProcessUuid::fromNative(null);
        $item = Item::fromNative($userDto->normalize());
        
        return new ItemCreateTaskCommand($uuid, $item);
    }
}