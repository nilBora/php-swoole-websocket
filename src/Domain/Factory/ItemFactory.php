<?php

declare(strict_types=1);

namespace Jtrw\Micro\Poc\Rpc\Domain\Factory;

use Jtrw\Micro\Poc\Rpc\Domain\Entity\ItemEntity;
use Jtrw\Micro\Poc\Rpc\Domain\Exception\ValueObjectInvalidException;
use Jtrw\Micro\Poc\Rpc\Domain\ValueObject\Item as ItemValueObject;
use Jtrw\Micro\Poc\Rpc\Domain\ValueObject\Uuid;
use MicroModule\ValueObject\Identity\UUID as ProcessUuid;

/**
 * Class ItemFactory.
 *
 * @category Domain\Factory
 */
class ItemFactory
{
    /**
     * Factory method for initialize new ItemEntity object.
     *
     * @param ProcessUuid     $processUuid
     * @param Uuid            $uuid
     * @param ItemValueObject $itemValueObject
     *
     * @return ItemEntity
     */
    public function createInstance(
        ProcessUuid $processUuid,
        Uuid $uuid,
        ItemValueObject $itemValueObject
    ): ItemEntity {
        return ItemEntity::create($processUuid, $uuid, $itemValueObject);
    }

    /**
     * Factory method for initialize actual ItemEntity object.
     *
     * @param Uuid            $uuid
     * @param ItemValueObject $itemValueObject
     *
     * @return ItemEntity
     *
     * @throws ValueObjectInvalidException
     */
    public function makeActualInstance(Uuid $uuid, ItemValueObject $itemValueObject): ItemEntity
    {
        return ItemEntity::createActual($uuid, $itemValueObject);
    }
}
