<?php

declare(strict_types=1);

namespace Jtrw\Micro\Poc\Rpc\Application\CommandHandler;

use Jtrw\Micro\Poc\Rpc\Domain\Command\ItemDeleteTaskCommand;
use Jtrw\Micro\Poc\Rpc\Domain\Repository\ItemTaskRepositoryInterface;
use Throwable;

/**
 * Class ItemDeleteTaskHandler.
 */
final class ItemDeleteTaskHandler implements CommandHandlerInterface
{
    /**
     * EventSourcing repository for ItemEntity.
     *
     * @var ItemTaskRepositoryInterface
     */
    private ItemTaskRepositoryInterface $itemTaskRepository;

    /**
     * ImportItemDtoHandler constructor.
     *
     * @param ItemTaskRepositoryInterface $itemTaskRepository
     */
    public function __construct(
        ItemTaskRepositoryInterface $itemTaskRepository
    ) {
        $this->itemTaskRepository = $itemTaskRepository;
    }

    /**
     * Handle ItemDeleteTaskCommand command.
     *
     * @param ItemDeleteTaskCommand $command
     *
     * @return bool
     *
     * @throws Throwable
     */
    public function handle(ItemDeleteTaskCommand $command): bool
    {
        $this->itemTaskRepository->addDeleteTask($command->getProcessUuid(), $command->getItemUuid());

        return true;
    }
}
