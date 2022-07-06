<?php

namespace Jtrw\Micro\Poc\Rpc\Domain\Query;

use MicroModule\Base\Domain\Command\CommandInterface;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;

class PingCommand implements CommandInterface
{
    public function getUuid(): UuidInterface
    {
        return Uuid::uuid6();
    }
}