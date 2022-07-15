<?php

declare(strict_types=1);

namespace Jtrw\Micro\Poc\Rpc\Infrastructure\Repository;

use Jtrw\Micro\Poc\Rpc\Domain\Entity\ItemEntity;
use Jtrw\Micro\Poc\Rpc\Domain\Repository\ItemRepositoryInterface;
use Jtrw\Micro\Poc\Rpc\Domain\ValueObject\Uuid;
use InvalidArgumentException;
use MicroModule\Snapshotting\EventSourcing\SnapshottingEventSourcingRepository;
use MicroModule\Snapshotting\EventSourcing\SnapshottingEventSourcingRepositoryException;

/**
 * Class ItemStore.
 *
 * @category Infrastructure\Repository
 * @sub-package ItemCollection
 */
class ItemStoreRepository extends SnapshottingEventSourcingRepository implements ItemRepositoryInterface
{
    /**
     * Return ItemEntity with applied events.
     *
     * @param Uuid $itemId
     *
     * @return ItemEntity
     */
    public function get(Uuid $itemId): ItemEntity
    {
        $itemEntity = $this->load($itemId->toNative());

        if (!$itemEntity instanceof ItemEntity) {
            throw new InvalidArgumentException('return object should implements ItemEntity');
        }

        return $itemEntity;
    }

    /**
     * Save ItemEntity last uncommitted events.
     *
     * @param ItemEntity $itemEntity
     *
     * @throws SnapshottingEventSourcingRepositoryException
     */
    public function store(ItemEntity $itemEntity): void
    {
        $this->save($itemEntity);
    }
}
