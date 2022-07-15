<?php

declare(strict_types=1);

namespace Jtrw\Micro\Poc\Rpc\Application\CommandHandler;

use Jtrw\Micro\Poc\Rpc\Domain\Command\ItemDeleteCommand;
use Jtrw\Micro\Poc\Rpc\Domain\Repository\ItemRepositoryInterface;
use Throwable;

/**
 * Class ItemDeleteHandler.
 */
final class ItemDeleteHandler implements CommandHandlerInterface
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
     * Handle ItemDeleteCommand command.
     *
     * @param ItemDeleteCommand $command
     *
     * @throws Throwable
     *
     * @suppress PhanTypeMismatchArgument
     */
    public function handle(ItemDeleteCommand $command): void
    {
        $item = $this->itemRepository->get($command->getItemUuid());
        $item->delete();
        $this->itemRepository->store($item);
    }
}
