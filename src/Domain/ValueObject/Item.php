<?php

declare(strict_types=1);

namespace Jtrw\Micro\Poc\Rpc\Domain\ValueObject;

use Jtrw\Micro\Poc\Rpc\Domain\Exception\ValueObjectInvalidException;
use Jtrw\Micro\Poc\Rpc\Domain\Exception\ValueObjectInvalidNativeValueException;
use Broadway\Serializer\Serializable;
use DateTime;
use Exception;
use MicroModule\ValueObject\DateTime\Exception\InvalidDateException;
use MicroModule\ValueObject\ValueObjectInterface;

/**
 * Class Item.
 *
 * @SuppressWarnings(PHPMD)
 */
class Item implements ValueObjectInterface, Serializable
{
    /**
     * Fields, that should be compared.
     *
     * @var array
     */
    public const COMPARED_FIELDS = [
        'parentId',
        'name',
        'url',
        'status',
    ];

    /**
     * Id ValueObject.
     *
     * @var Id|null
     */
    private ?Id $id = null;

    /**
     * ParentId ValueObject.
     *
     * @var ParentId|null
     */
    private ?ParentId $parentId = null;

    /**
     * Name ValueObject.
     *
     * @var Name|null
     */
    private ?Name $name = null;

    /**
     * Status ValueObject.
     *
     * @var Status|null
     */
    private ?Status $status = null;

    /**
     * Url ValueObject.
     *
     * @var Url|null
     */
    private ?Url $url = null;

    /**
     * CreatedAt ValueObject.
     *
     * @var CreatedAt|null
     */
    private ?CreatedAt $createdAt = null;

    /**
     * UpdatedAt ValueObject.
     *
     * @var UpdatedAt|null
     */
    private ?UpdatedAt $updatedAt = null;

    /**
     * Make Item from item DTO object.
     *
     * @return Item
     *
     * @throws Exception
     */
    public static function fromNative(): static
    {
        $item = func_get_arg(0);

        if (is_array($item)) {
            return static::fromArray($item);
        }

        if (is_string($item)) {
            $item = unserialize($item, ['allowed_classes' => false]);

            return static::fromArray($item);
        }

        throw new ValueObjectInvalidNativeValueException('Invalid native value');
    }

    /**
     * Build Item object from array.
     *
     * @param mixed[] $item
     *
     * @return Item
     *
     * @throws InvalidDateException
     *
     * @suppress PhanTypeMismatchArgument
     * @psalm-suppress ArgumentTypeCoercion
     */
    private static function fromArray(array $item): self
    {
        $itemValueObject = new self();

        if (isset($item['id'])) {
            $itemValueObject->setId(Id::fromNative($item['id']));
        }

        if (isset($item['parentId'])) {
            $itemValueObject->setParentId(ParentId::fromNative($item['parentId']));
        }

        if (isset($item['parent_id'])) {
            $itemValueObject->setParentId(ParentId::fromNative($item['parent_id']));
        }

        if (isset($item['name'])) {
            $itemValueObject->setName(Name::fromNative($item['name']));
        }

        if (isset($item['status'])) {
            $itemValueObject->setStatus(Status::fromNative($item['status']));
        }

        if (isset($item['url'])) {
            $itemValueObject->setUrl(Url::fromNative($item['url']));
        }

        if (isset($item['createdAt'])) {
            $itemValueObject->setCreatedAt(CreatedAt::fromNative($item['createdAt']));
        }

        if (isset($item['created_at'])) {
            $itemValueObject->setCreatedAt(CreatedAt::fromNative($item['created_at']));
        }

        if (isset($item['updatedAt'])) {
            $itemValueObject->setUpdatedAt(UpdatedAt::fromNative($item['updatedAt']));
        }

        if (isset($item['updated_at'])) {
            $itemValueObject->setUpdatedAt(UpdatedAt::fromNative($item['updated_at']));
        }

        return $itemValueObject;
    }

    /**
     * Convert to array.
     *
     * @return mixed[]
     *
     * @throws Exception
     */
    public function toArray(): array
    {
        $item = [];

        if (null !== $this->id) {
            $item['id'] = $this->id->toNative();
        }

        if (null !== $this->parentId) {
            $item['parentId'] = $this->parentId->toNative();
        }

        if (null !== $this->name) {
            $item['name'] = $this->name->toNative();
        }

        if (null !== $this->status) {
            $item['status'] = $this->status->toNative();
        }

        if (null !== $this->url) {
            $item['url'] = $this->url->toNative();
        }

        if (null !== $this->createdAt) {
            $item['createdAt'] = $this->createdAt->toNative()->format(DateTime::ATOM);
        }

        if (null !== $this->updatedAt) {
            $item['updatedAt'] = $this->updatedAt->toNative()->format(DateTime::ATOM);
        }

        return $item;
    }

    /**
     * Tells whether two Collection are equal by comparing their size and items (item order matters).
     *
     * @param ValueObjectInterface $valueObject
     *
     * @return bool
     *
     * @throws ValueObjectInvalidException
     */
    public function sameValueAs(ValueObjectInterface $valueObject): bool
    {
        if (!$valueObject instanceof static) {
            return false;
        }

        foreach (self::COMPARED_FIELDS as $field) {
            $getMethodName = 'get' . ucfirst($field);
            $field = $this->{$getMethodName}();
            $itemProperty = $valueObject->{$getMethodName}();

            if (null === $field && null === $itemProperty) {
                continue;
            }

            if (null === $field || null === $itemProperty) {
                return false;
            }

            if (
                !$field instanceof ValueObjectInterface ||
                !$itemProperty instanceof ValueObjectInterface
            ) {
                throw new ValueObjectInvalidException('Some of value not instance of \'ValueObjectInterface\'');
            }

            if (!$field->sameValueAs($itemProperty)) {
                return false;
            }
        }

        return true;
    }

    /**
     * Return native value.
     *
     * @return mixed[]
     *
     * @throws Exception
     */
    public function toNative()
    {
        return $this->toArray();
    }

    /**
     * Returns a native string representation of the Collection object.
     *
     * @return string
     *
     * @throws Exception
     */
    public function __toString(): string
    {
        return serialize($this->toArray());
    }

    /**
     * Return Id ValueObject.
     *
     * @return Id|null
     */
    public function getId(): ?Id
    {
        return $this->id;
    }

    /**
     * Set Id ValueObject.
     *
     * @param Id|null $id
     */
    public function setId(?Id $id): void
    {
        $this->id = $id;
    }

    /**
     * Return ParentId ValueObject.
     *
     * @return ParentId|null
     */
    public function getParentId(): ?ParentId
    {
        return $this->parentId;
    }

    /**
     * Set ParentId ValueObject.
     *
     * @param ParentId $parentId
     *
     * @return $this
     */
    public function setParentId(ParentId $parentId): self
    {
        $this->parentId = $parentId;

        return $this;
    }

    /**
     * Return Name ValueObject.
     *
     * @return Name|null
     */
    public function getName(): ?Name
    {
        return $this->name;
    }

    /**
     * Set Name ValueObject.
     *
     * @param Name $name
     *
     * @return $this
     */
    public function setName(Name $name): self
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Return Status ValueObject.
     *
     * @return Status|null
     */
    public function getStatus(): ?Status
    {
        return $this->status;
    }

    /**
     * Set Status ValueObject.
     *
     * @param Status $status
     *
     * @return $this
     */
    public function setStatus(Status $status): self
    {
        $this->status = $status;

        return $this;
    }

    /**
     * Return Url ValueObject.
     *
     * @return Url|null
     */
    public function getUrl(): ?Url
    {
        return $this->url;
    }

    /**
     * Set Url ValueObject.
     *
     * @param Url $url
     *
     * @return $this
     */
    public function setUrl(Url $url): self
    {
        $this->url = $url;

        return $this;
    }

    /**
     * Return CreatedAt ValueObject.
     *
     * @return CreatedAt|null
     */
    public function getCreatedAt(): ?CreatedAt
    {
        return $this->createdAt;
    }

    /**
     * Set CreatedAt ValueObject.
     *
     * @param CreatedAt $createdAt
     *
     * @return $this
     */
    public function setCreatedAt(CreatedAt $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * Return UpdatedAt ValueObject.
     *
     * @return UpdatedAt|null
     */
    public function getUpdatedAt(): ?UpdatedAt
    {
        return $this->updatedAt;
    }

    /**
     * Set UpdatedAt ValueObject.
     *
     * @param UpdatedAt $updatedAt
     *
     * @return $this
     */
    public function setUpdatedAt(UpdatedAt $updatedAt): self
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    /**
     * Convert array to Item ValueObject.
     *
     * @param mixed[] $item
     *
     * @return Item
     *
     * @throws Exception
     */
    public static function deserialize(array $item): self
    {
        return static::fromNative($item);
    }

    /**
     * Convert Item ValueObject to array.
     *
     * @return mixed[]
     *
     * @throws Exception
     */
    public function serialize(): array
    {
        return $this->toNative();
    }
}
