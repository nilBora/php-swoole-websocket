<?php

declare(strict_types=1);

namespace Jtrw\Micro\Poc\Rpc\Domain\Factory;

use Jtrw\Micro\Poc\Rpc\Domain\ValueObject\CreatedAt;
use Jtrw\Micro\Poc\Rpc\Domain\ValueObject\Id;
use Jtrw\Micro\Poc\Rpc\Domain\ValueObject\Item;
use Jtrw\Micro\Poc\Rpc\Domain\ValueObject\Name;
use Jtrw\Micro\Poc\Rpc\Domain\ValueObject\ParentId;
use Jtrw\Micro\Poc\Rpc\Domain\ValueObject\Status;
use Jtrw\Micro\Poc\Rpc\Domain\ValueObject\UpdatedAt;
use Jtrw\Micro\Poc\Rpc\Domain\ValueObject\Url;
use Jtrw\Micro\Poc\Rpc\Domain\ValueObject\Uuid;
use Exception;
use MicroModule\ValueObject\DateTime\Exception\InvalidDateException;

/**
 * Class ValueObjectFactory.
 *
 * @category Domain\Factory
 *
 * @SuppressWarnings(PHPMD)
 */
class ValueObjectFactory
{
    /**
     * Factory method for initialize new Item value object.
     *
     * @param mixed $item
     *
     * @return Item
     *
     * @throws Exception
     */
    public function makeItem($item): Item
    {
        return Item::fromNative($item);
    }

    /**
     * Factory method for initialize new itemId value object.
     *
     * @param int|null $itemId
     *
     * @return Id
     *
     * @suppress PhanPartialTypeMismatchReturn
     */
    public function makeId(?int $itemId = null): Id
    {
        return Id::fromNative($itemId);
    }

    /**
     * Factory method for initialize new uuid value object.
     *
     * @param string|null $uuid
     *
     * @return Uuid
     *
     * @throws Exception
     *
     * @suppress PhanPartialTypeMismatchReturn
     */
    public function makeUuid(?string $uuid = null): Uuid
    {
        return Uuid::fromNative($uuid);
    }

    /**
     * Factory method for initialize new ParentId value object.
     *
     * @param int $parentId
     *
     * @return ParentId
     *
     * @suppress PhanPartialTypeMismatchReturn
     */
    public function makeParentId(int $parentId): ParentId
    {
        return ParentId::fromNative($parentId);
    }

    /**
     * Factory method for initialize new Name value object.
     *
     * @param string $name
     *
     * @return Name
     *
     * @suppress PhanPartialTypeMismatchReturn
     */
    public function makeName(string $name): Name
    {
        return Name::fromNative($name);
    }

    /**
     * Factory method for initialize new Url value object.
     *
     * @param string $url
     *
     * @return Url
     *
     * @suppress PhanPartialTypeMismatchReturn
     */
    public function makeUrl(string $url): Url
    {
        return Url::fromNative($url);
    }

    /**
     * Factory method for initialize new Status value object.
     *
     * @param int $status
     *
     * @return Status
     *
     * @suppress PhanPartialTypeMismatchReturn
     */
    public function makeStatus(int $status): Status
    {
        return Status::fromNative($status);
    }

    /**
     * Factory method for initialize new CreatedAt value object.
     *
     * @param string $createdAt
     *
     * @return CreatedAt
     *
     * @throws InvalidDateException
     *
     * @suppress PhanPartialTypeMismatchReturn
     */
    public function makeCreatedAt(string $createdAt): CreatedAt
    {
        return CreatedAt::fromNative($createdAt);
    }

    /**
     * Factory method for initialize new UpdatedAt value object.
     *
     * @param string $updatedAt
     *
     * @return UpdatedAt
     *
     * @throws InvalidDateException
     *
     * @suppress PhanPartialTypeMismatchReturn
     */
    public function makeUpdatedAt(string $updatedAt): UpdatedAt
    {
        return UpdatedAt::fromNative($updatedAt);
    }
}
