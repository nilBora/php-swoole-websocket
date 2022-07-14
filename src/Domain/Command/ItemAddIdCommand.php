<?php

declare(strict_types=1);

namespace Jtrw\Micro\Poc\Rpc\Domain\Command;

use Jtrw\Micro\Poc\Rpc\Domain\ValueObject\Id;
use Jtrw\Micro\Poc\Rpc\Domain\ValueObject\Uuid;
use MicroModule\ValueObject\Identity\UUID as ProcessUuid;

/**
 * Class ItemAddIdCommand.
 */
class ItemAddIdCommand extends ItemCommand
{
    /**
     * Item primary key value.
     *
     * @var Uuid
     */
    private Uuid $uuid;

    /**
     * Item unique integer identifier.
     *
     * @var Id
     */
    private Id $id;

    /**
     * InitItemCommand constructor.
     *
     * @param ProcessUuid $processUuid
     * @param Uuid        $uuid
     * @param Id          $id
     */
    public function __construct(ProcessUuid $processUuid, Uuid $uuid, Id $id)
    {
        parent::__construct($processUuid);
        $this->uuid = $uuid;
        $this->id = $id;
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

    /**
     * Return Id value object.
     *
     * @return Id
     */
    public function getId(): Id
    {
        return $this->id;
    }
}
