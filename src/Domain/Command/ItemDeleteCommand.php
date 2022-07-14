<?php

declare(strict_types=1);

namespace Jtrw\Micro\Poc\Rpc\Domain\Command;

use Jtrw\Micro\Poc\Rpc\Domain\ValueObject\Uuid;
use MicroModule\ValueObject\Identity\UUID as ProcessUuid;

/**
 * Class ItemDeleteCommand.
 */
class ItemDeleteCommand extends ItemCommand
{
    /**
     * Item primary key value.
     *
     * @var Uuid
     */
    private Uuid $uuid;

    /**
     * InitItemCommand constructor.
     *
     * @param ProcessUuid $processUuid
     * @param Uuid        $uuid
     */
    public function __construct(ProcessUuid $processUuid, Uuid $uuid)
    {
        parent::__construct($processUuid);
        $this->uuid = $uuid;
    }

    /**
     * Return Uuid object.
     *
     * @return Uuid
     */
    public function getItemUuid(): Uuid
    {
        return $this->uuid;
    }
}
