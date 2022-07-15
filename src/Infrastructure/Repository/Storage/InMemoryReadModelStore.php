<?php

declare(strict_types=1);

namespace Jtrw\Micro\Poc\Rpc\Infrastructure\Repository\Storage;

use Jtrw\Micro\Poc\Rpc\Domain\Entity\EntityInterface;
use Jtrw\Micro\Poc\Rpc\Domain\Repository\ReadModelStoreInterface;
use UnexpectedValueException;

/**
 * In-memory implementation of an snapshot store.
 *
 * Useful for testing code that uses an snapshot store.
 */
final class InMemoryReadModelStore implements ReadModelStoreInterface
{
    /**
     * ReadModels in memory storage.
     *
     * @var mixed[]
     */
    private array $items = [];

    /**
     * Table primary key.
     *
     * @var string
     */
    private string $primaryKey;

    /**
     * InMemoryReadModelStore constructor.
     *
     * @param string $primaryKey
     */
    public function __construct(
        string $primaryKey
    ) {
        $this->primaryKey = $primaryKey;
    }

    /**
     * Finds an object by its primary key / identifier.
     *
     * @param mixed $uuid
     *
     * @return mixed[]|null
     */
    public function findOne($uuid): ?array
    {
        return $this->items[$uuid] ?? null;
    }

    /**
     * Finds all objects in the repository.
     *
     * @return mixed[]
     */
    public function findAll(): array
    {
        return $this->items;
    }

    /**
     * Finds objects by a set of criteria.
     *
     * Optionally sorting and limiting details can be passed. An implementation may throw
     * an UnexpectedValueException if certain values of the sorting or limiting details are
     * not supported.
     *
     * @param array      $criteria
     * @param array|null $orderBy
     * @param int|null   $limit
     * @param int|null   $offset
     *
     * @return mixed[]
     *
     * @throws UnexpectedValueException
     *
     * @suppress PhanUnusedPublicFinalMethodParameter
     */
    public function findBy(array $criteria, ?array $orderBy = null, ?int $limit = null, ?int $offset = null): array
    {
        return $this->items;
    }

    /**
     * Finds a single object by a set of criteria.
     *
     * @param mixed[] $criteria
     *
     * @return mixed[]|null
     *
     * @suppress PhanUnusedPublicFinalMethodParameter
     */
    public function findOneBy(array $criteria): ?array
    {
        if (!isset($criteria[$this->primaryKey])) {
            throw new NotFoundException('Primary key not found in criteria');
        }

        return $this->items[$criteria[$this->primaryKey]];
    }

    /**
     * Insert new item into storage.
     *
     * @param EntityInterface $entity
     */
    public function insertOne(EntityInterface $entity): void
    {
        $this->items[$entity->getPrimaryKeyValue()] = $entity->normalize();
    }

    /**
     * Update one item in store.
     *
     * @param EntityInterface $entity
     */
    public function updateOne(EntityInterface $entity): void
    {
        $idNative = $entity->getPrimaryKeyValue();
        $this->items[$idNative] = array_merge($this->items[$idNative], $entity->normalize());
    }

    /**
     * Append new snapshot payload into storage.
     *
     * @param EntityInterface $entity
     */
    public function deleteOne(EntityInterface $entity): void
    {
        unset($this->items[$entity->getPrimaryKeyValue()]);
    }
}
