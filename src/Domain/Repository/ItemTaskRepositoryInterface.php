<?php

declare(strict_types=1);

namespace Jtrw\Micro\Poc\Rpc\Domain\Repository;

use Jtrw\Micro\Poc\Rpc\Domain\ValueObject\Item;
use Jtrw\Micro\Poc\Rpc\Domain\ValueObject\Uuid;
use MicroModule\ValueObject\Identity\UUID as ProcessUuid;

/**
 * Interface ItemTaskRepositoryInterface.
 *
 * @category Domain\Query\Repository
 */
interface ItemTaskRepositoryInterface
{
    /**
     * Send job task to queue.
     *
     * @param ProcessUuid $processUuid
     * @param Item        $item
     */
    public function addCreateTask(ProcessUuid $processUuid, Item $item): void;

    /**
     * Send job task to queue.
     *
     * @param ProcessUuid $processUuid
     * @param Uuid        $itemUuid
     * @param Item        $item
     */
    public function addUpdateTask(ProcessUuid $processUuid, Uuid $itemUuid, Item $item): void;

    /**
     * Send job task to queue.
     *
     * @param ProcessUuid $processUuid
     * @param Uuid        $itemUuid
     */
    public function addDeleteTask(ProcessUuid $processUuid, Uuid $itemUuid): void;
}
