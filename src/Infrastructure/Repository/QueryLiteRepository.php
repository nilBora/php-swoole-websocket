<?php

declare(strict_types=1);

namespace Jtrw\Micro\Poc\Rpc\Infrastructure\Repository;

use Jtrw\Micro\Poc\Rpc\Domain\Repository\QueryLiteRepositoryInterface;
use Jtrw\Micro\Poc\Rpc\Domain\Repository\ReadModelStoreInterface;
use Jtrw\Micro\Poc\Rpc\Domain\ValueObject\FindCriteria;
use Jtrw\Micro\Poc\Rpc\Domain\ValueObject\Uuid;
use Jtrw\Micro\Poc\Rpc\Infrastructure\Repository\Storage\NotFoundException;
use Exception;
use MicroModule\Base\Utils\LoggerTrait;

/**
 * Class QueryLiteRepository.
 *
 * @category Infrastructure\Query
 */
class QueryLiteRepository implements QueryLiteRepositoryInterface
{
    use LoggerTrait;

    /**
     * ReadModel repository.
     *
     * @var ReadModelStoreInterface
     */
    private ReadModelStoreInterface $readModelStore;

    /**
     * RequestRepositoryRepository constructor.
     *
     * @param ReadModelStoreInterface $readModelStore
     */
    public function __construct(ReadModelStoreInterface $readModelStore)
    {
        $this->readModelStore = $readModelStore;
    }

    /**
     * Find and return item entity by item uuid.
     *
     * @param Uuid $uuid
     *
     * @return mixed[]|null
     *
     * @throws Exception
     */
    public function findByUuid(Uuid $uuid): ?array
    {
        try {
            return $this->readModelStore->findOne($uuid->toNative());
        } catch (NotFoundException $e) {
            return null;
        }
    }

    /**
     * Find and return array of ItemEntity by FindCriteria.
     *
     * @param FindCriteria $findCriteria
     *
     * @return mixed[]|null
     */
    public function findByCriteria(FindCriteria $findCriteria): ?array
    {
        try {
            return $this->readModelStore->findBy($findCriteria->toNative());
        } catch (NotFoundException $e) {
            return null;
        }
    }
}
