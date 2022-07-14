<?php

declare(strict_types=1);

namespace Jtrw\Micro\Poc\Rpc\Domain\Command;

use Exception;
use MicroModule\Base\Domain\Command\CommandInterface;
use MicroModule\ValueObject\Identity\UUID;
use Ramsey\Uuid\UuidInterface;

/**
 * Class ItemCommand.
 */
abstract class ItemCommand implements CommandInterface
{
    /**
     * Process uuid.
     *
     * @var UUID
     */
    private UUID $processUuid;

    /**
     * InitItemCommand constructor.
     *
     * @param UUID $processUuid
     */
    public function __construct(UUID $processUuid)
    {
        $this->processUuid = $processUuid;
    }

    /**
     * Return UUID.
     *
     * @return UUID
     *
     * @throws Exception
     */
    public function getProcessUuid(): UUID
    {
        return $this->processUuid;
    }

    /**
     * Return Uuid.
     *
     * @return UuidInterface
     *
     * @throws Exception
     */
    public function getUuid(): UuidInterface
    {
        return $this->processUuid->getUuid();
    }
}
