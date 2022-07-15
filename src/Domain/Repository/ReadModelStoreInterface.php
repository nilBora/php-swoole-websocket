<?php

declare(strict_types=1);

namespace Jtrw\Micro\Poc\Rpc\Domain\Repository;

use Jtrw\Micro\Poc\Rpc\Domain\Entity\EntityInterface;
use UnexpectedValueException;

/**
 * Interface ReadModelStoreInterface.
 *
 * @category Domain\Repository
 */
interface ReadModelStoreInterface
{
    /**
     * Finds an object by its primary key / identifier.
     *
     * @param mixed $uuid the identifier
     *
     * @return mixed[]|null
     */
    public function findOne($uuid): ?array;

    /**
     * Finds all objects in the repository.
     *
     * @return mixed[]
     */
    public function findAll(): array;

    /**
     * Finds objects by a set of criteria.
     *
     * Optionally sorting and limiting details can be passed. An implementation may throw
     * an UnexpectedValueException if certain values of the sorting or limiting details are
     * not supported.
     *
     * @param mixed[]       $criteria
     * @param string[]|null $orderBy
     * @param int|null      $limit
     * @param int|null      $offset
     *
     * @return mixed[]
     *
     * @throws UnexpectedValueException
     */
    public function findBy(array $criteria, ?array $orderBy = null, ?int $limit = null, ?int $offset = null): array;

    /**
     * Finds a single object by a set of criteria.
     *
     * @param mixed[] $criteria the criteria
     *
     * @return mixed[]|null
     */
    public function findOneBy(array $criteria): ?array;

    /**
     * Insert new item into storage.
     *
     * @param EntityInterface $entity
     */
    public function insertOne(EntityInterface $entity): void;

    /**
     * Update one item in store.
     *
     * @param EntityInterface $entity
     */
    public function updateOne(EntityInterface $entity): void;

    /**
     * Append new snapshot payload into storage.
     *
     * @param EntityInterface $entity
     */
    public function deleteOne(EntityInterface $entity): void;
}
