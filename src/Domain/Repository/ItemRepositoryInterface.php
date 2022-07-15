<?php

declare(strict_types=1);

namespace Jtrw\Micro\Poc\Rpc\Domain\Repository;

use Jtrw\Micro\Poc\Rpc\Domain\Entity\ItemEntity;
use Jtrw\Micro\Poc\Rpc\Domain\ValueObject\Uuid;

/**
 * Interface ItemRepositoryInterface.
 *
 * @category Domain\Repository
 * @sub-package Item
 */
interface ItemRepositoryInterface
{
    /**
     * Return ItemEntity with applied events.
     *
     * @param Uuid $itemId
     *
     * @return ItemEntity
     */
    public function get(Uuid $itemId): ItemEntity;

    /**
     * Save ItemEntity last uncommitted events.
     *
     * @param ItemEntity $item
     */
    public function store(ItemEntity $item): void;
}
