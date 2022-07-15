<?php

declare(strict_types=1);

namespace Jtrw\Micro\Poc\Rpc\Domain\Repository;

use Jtrw\Micro\Poc\Rpc\Domain\Entity\ItemEntity;

/**
 * Interface CommandRepositoryInterface.
 *
 * @category Domain\Query\Repository
 */
interface CommandRepositoryInterface
{
    /**
     * Add new item entity.
     *
     * @param ItemEntity $itemEntity
     */
    public function add(ItemEntity $itemEntity): void;

    /**
     * Update item entity.
     *
     * @param ItemEntity $itemEntity
     */
    public function update(ItemEntity $itemEntity): void;

    /**
     * Delete item entity.
     *
     * @param ItemEntity $itemEntity
     */
    public function delete(ItemEntity $itemEntity): void;
}
