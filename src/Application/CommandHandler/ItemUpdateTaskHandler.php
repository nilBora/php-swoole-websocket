<?php

declare(strict_types=1);

namespace Jtrw\Micro\Poc\Rpc\Application\CommandHandler;

use Jtrw\Micro\Poc\Rpc\Domain\Command\ItemUpdateTaskCommand;
use Jtrw\Micro\Poc\Rpc\Domain\Repository\ItemTaskRepositoryInterface;
use Throwable;

/**
 * Class ItemUpdateTaskHandler.
 */
final class ItemUpdateTaskHandler implements CommandHandlerInterface
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
     * Handle ItemUpdateTaskCommand command.
     *
     * @param ItemUpdateTaskCommand $command
     *
     * @return bool
     *
     * @throws Throwable
     */
    public function handle(ItemUpdateTaskCommand $command): bool
    {
        $this->itemTaskRepository->addUpdateTask($command->getProcessUuid(), $command->getItemUuid(), $command->getItem());

        return true;
    }
}
