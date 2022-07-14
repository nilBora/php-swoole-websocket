<?php

declare(strict_types=1);

namespace Jtrw\Micro\Poc\Rpc\Domain\Command;

use Jtrw\Micro\Poc\Rpc\Domain\ValueObject\Item;
use Jtrw\Micro\Poc\Rpc\Domain\ValueObject\Uuid;
use MicroModule\ValueObject\Identity\UUID as ProcessUuid;

/**
 * Class ItemCreateCommand.
 */
final class ItemCreateCommand extends ItemCommand
{
    /**
     * Item primary key value.
     *
     * @var Uuid
     */
    private Uuid $uuid;

    /**
     * Item ValueObject.
     *
     * @var Item
     */
    private Item $item;

    /**
     * InitItemCommand constructor.
     *
     * @param ProcessUuid $processUuid
     * @param Uuid        $uuid
     * @param Item        $item
     */
    public function __construct(ProcessUuid $processUuid, Uuid $uuid, Item $item)
    {
        parent::__construct($processUuid);
        $this->uuid = $uuid;
        $this->item = $item;
    }

    /**
     * Return Id object.
     *
     * @return Uuid
     */
    public function getItemUuid(): Uuid
    {
        return $this->uuid;
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
