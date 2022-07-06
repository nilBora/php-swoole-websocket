<?php

namespace Jtrw\Micro\Poc\Rpc\Domain\Factory;

use Jtrw\Micro\Poc\Rpc\Domain\Query\PingCommand;
use MicroModule\Base\Domain\Command\CommandInterface;
use MicroModule\Base\Domain\Exception\FactoryException;
use MicroModule\Base\Domain\Factory\CommandFactoryInterface;

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
}