<?php

declare(strict_types=1);

namespace Jtrw\Micro\Poc\Rpc\Domain\Command;

use Jtrw\Micro\Poc\Rpc\Domain\ValueObject\Item;
use MicroModule\ValueObject\Identity\UUID;

/**
 * Class ItemCreateTaskCommand.
 */
final class ItemCreateTaskCommand extends ItemCommand
{
    /**
     * Item ValueObject.
     *
     * @var Item
     */
    private Item $item;

    /**
     * InitItemCommand constructor.
     *
     * @param UUID $processUuid
     * @param Item $item
     */
    public function __construct(UUID $processUuid, Item $item)
    {
        parent::__construct($processUuid);
        $this->item = $item;
    }

    /**
     * Return Item value object.
     *
     * @return Item
     */
    public function getItem(): Item
    {
        return $this->item;
    }
}
