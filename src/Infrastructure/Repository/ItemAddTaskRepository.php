<?php

declare(strict_types=1);

namespace Jtrw\Micro\Poc\Rpc\Infrastructure\Repository;

use Jtrw\Micro\Poc\Rpc\Domain\Factory\CommandFactory;
use Jtrw\Micro\Poc\Rpc\Domain\Repository\ItemTaskRepositoryInterface;
use Jtrw\Micro\Poc\Rpc\Domain\ValueObject\Item;
use Jtrw\Micro\Poc\Rpc\Domain\ValueObject\Uuid;
use Enqueue\Client\ProducerInterface;
use Exception;
use MicroModule\Base\Utils\LoggerTrait;
use MicroModule\Task\Application\Processor\JobCommandBusProcessor;
use MicroModule\ValueObject\Identity\UUID as ProcessUuid;

/**
 * Class ItemAddTaskRepository.
 *
 * @category Infrastructure\Query\Queue
 */
class ItemAddTaskRepository implements ItemTaskRepositoryInterface
{
    use LoggerTrait;

    public const QUEUE_MASTER_DATA = 'item.add';

    /**
     * Queue producer.
     *
     * @var ProducerInterface
     */
    private ProducerInterface $queueProducer;

    /**
     * ItemAddTaskRepository constructor.
     *
     * @param ProducerInterface $taskProducer
     */
    public function __construct(ProducerInterface $taskProducer)
    {
        $this->queueProducer = $taskProducer;
    }

    /**
     * Send job task to queue.
     *
     * @param ProcessUuid $processUuid
     * @param Item        $item
     *
     * @throws Exception
     */
    public function addCreateTask(ProcessUuid $processUuid, Item $item): void
    {
        $args = [
            $processUuid->toNative(),
            $item->toNative(),
        ];
        $message = ['type' => CommandFactory::PROGRAM_READ_MODEL_CREATE_COMMAND, 'args' => $args];
        $this->queueProducer->sendCommand(JobCommandBusProcessor::getRoute(), $message);
    }

    /**
     * Send job task to queue.
     *
     * @param ProcessUuid $processUuid
     * @param Uuid        $itemUuid
     * @param Item        $item
     *
     * @throws Exception
     */
    public function addUpdateTask(ProcessUuid $processUuid, Uuid $itemUuid, Item $item): void
    {
        $args = [
            $processUuid->toNative(),
            $itemUuid->toNative(),
            $item->toNative(),
        ];
        $message = ['type' => CommandFactory::PROGRAM_READ_MODEL_UPDATE_COMMAND, 'args' => $args];
        $this->queueProducer->sendCommand(JobCommandBusProcessor::getRoute(), $message);
    }

    /**
     * Send job task to queue.
     *
     * @param ProcessUuid $processUuid
     * @param Uuid        $itemUuid
     *
     * @throws Exception
     */
    public function addDeleteTask(ProcessUuid $processUuid, Uuid $itemUuid): void
    {
        $args = [
            $processUuid->toNative(),
            $itemUuid->toNative(),
        ];
        $message = ['type' => CommandFactory::PROGRAM_READ_MODEL_DELETE_COMMAND, 'args' => $args];
        $this->queueProducer->sendCommand(JobCommandBusProcessor::getRoute(), $message);
    }
}
