<?php

declare(strict_types=1);

namespace Jtrw\Micro\Poc\Rpc\Application\CommandHandler;

use Jtrw\Micro\Poc\Rpc\Domain\Command\ItemUpdateCommand;
use Jtrw\Micro\Poc\Rpc\Domain\Repository\ItemRepositoryInterface;
use Throwable;

/**
 * Class ItemUpdateHandler.
 */
final class ItemUpdateHandler implements CommandHandlerInterface
{
    /**
     * EventSourcing repository for ItemEntity.
     *
     * @var ItemRepositoryInterface
     */
    private ItemRepositoryInterface $itemRepository;

    /**
     * RequestHandler constructor.
     *
     * @param ItemRepositoryInterface $itemRepository
     */
    public function __construct(
        ItemRepositoryInterface $itemRepository
    ) {
        $this->itemRepository = $itemRepository;
    }

    /**
     * Handle UpdateItemCommand command.
     *
     * @param ItemUpdateCommand $command
     *
     * @throws Throwable
     *
     * @suppress PhanTypeMismatchArgument
     */
    public function handle(ItemUpdateCommand $command): void
    {
        $item = $this->itemRepository->get($command->getItemUuid());
        $item->update($command->getItem());
        $this->itemRepository->store($item);
    }
}
