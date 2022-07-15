<?php

declare(strict_types=1);

namespace Jtrw\Micro\Poc\Rpc\Infrastructure\Repository;

use Jtrw\Micro\Poc\Rpc\Domain\Entity\ItemEntity;
use Broadway\EventHandling\EventBus;
use Broadway\EventSourcing\AggregateFactory\PublicConstructorAggregateFactory;
use Broadway\EventSourcing\EventSourcingRepository;
use Broadway\EventSourcing\EventStreamDecorator;
use Broadway\EventStore\EventStore;

/**
 * Class ItemEventSourcingStoreRepository.
 *
 * @category Infrastructure\Repository
 * @sub-package ItemCollection
 */
class ItemEventSourcingStoreRepository extends EventSourcingRepository
{
    /**
     * ItemStore constructor.
     *
     * @param EventStore             $eventStore
     * @param EventBus               $eventBus
     * @param EventStreamDecorator[] $eventStreamDecorators
     */
    public function __construct(
        EventStore $eventStore,
        EventBus $eventBus,
        array $eventStreamDecorators = []
    ) {
        parent::__construct(
            $eventStore,
            $eventBus,
            ItemEntity::class,
            new PublicConstructorAggregateFactory(),
            $eventStreamDecorators
        );
    }
}
