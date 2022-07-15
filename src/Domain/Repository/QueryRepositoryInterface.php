<?php

declare(strict_types=1);

namespace Jtrw\Micro\Poc\Rpc\Domain\Repository;

use Jtrw\Micro\Poc\Rpc\Domain\Entity\ItemEntity;
use Jtrw\Micro\Poc\Rpc\Domain\ValueObject\FindCriteria;
use Jtrw\Micro\Poc\Rpc\Domain\ValueObject\Uuid;

/**
 * Interface QueryRepositoryInterface.
 *
 * @category Domain\Query\Repository
 */
interface QueryRepositoryInterface
{
    /**
     * Find and return item entity by item uuid.
     *
     * @param Uuid $uuid
     *
     * @return ItemEntity|null
     */
    public function findByUuid(Uuid $uuid): ?ItemEntity;

    /**
     * Find and return array of ItemEntity by FindCriteria.
     *
     * @param FindCriteria $findCriteria
     *
     * @return ItemEntity[]|mixed[]|null
     */
    public function findByCriteria(FindCriteria $findCriteria): ?array;
}
