<?php

declare(strict_types=1);

namespace Jtrw\Micro\Poc\Rpc\Domain\Entity;

use Jtrw\Micro\Poc\Rpc\Domain\Event\ItemIdWasAddedEvent;
use Jtrw\Micro\Poc\Rpc\Domain\Event\ItemWasCreatedEvent;
use Jtrw\Micro\Poc\Rpc\Domain\Event\ItemWasDeletedEvent;
use Jtrw\Micro\Poc\Rpc\Domain\Event\ItemWasUpdatedEvent;
use Jtrw\Micro\Poc\Rpc\Domain\Exception\ValueObjectInvalidException;
use Jtrw\Micro\Poc\Rpc\Domain\Factory\EventFactory;
use Jtrw\Micro\Poc\Rpc\Domain\ValueObject\CreatedAt;
use Jtrw\Micro\Poc\Rpc\Domain\ValueObject\Id;
use Jtrw\Micro\Poc\Rpc\Domain\ValueObject\Item as ItemValueObject;
use Jtrw\Micro\Poc\Rpc\Domain\ValueObject\Name;
use Jtrw\Micro\Poc\Rpc\Domain\ValueObject\ParentId;
use Jtrw\Micro\Poc\Rpc\Domain\ValueObject\Status;
use Jtrw\Micro\Poc\Rpc\Domain\ValueObject\UpdatedAt;
use Jtrw\Micro\Poc\Rpc\Domain\ValueObject\Url;
use Jtrw\Micro\Poc\Rpc\Domain\ValueObject\Uuid;
use Broadway\EventSourcing\EventSourcedAggregateRoot;
use DateTime;
use Exception;
use MicroModule\Snapshotting\EventSourcing\AggregateAssemblerInterface;
use MicroModule\ValueObject\Identity\UUID as ProcessUuid;
use MicroModule\ValueObject\ValueObjectInterface;

/**
 * Class ItemEntity.
 *
 * @category Domain\Entity
 * @sub-package Item
 *
 * @SuppressWarnings(PHPMD)
 */
class ItemEntity extends EventSourcedAggregateRoot implements AggregateAssemblerInterface, EntityInterface
{
    /**
     * EventFactory object.
     *
     * @var EventFactory
     */
    protected EventFactory $eventFactory;

    /**
     * Is was any updates from last time.
     *
     * @var bool
     */
    protected bool $wasUpdated = false;

    /**
     * Is was item deleted.
     *
     * @var bool
     */
    protected bool $wasDeleted = false;

    /**
     * Is this item new.
     *
     * @var bool
     */
    protected bool $isNew = false;

    /**
     * Process uuid.
     *
     * @var ProcessUuid
     */
    protected ProcessUuid $processUuid;

    /**
     * Item uuid.
     *
     * @var Uuid
     */
    protected Uuid $uuid;

    /**
     * Item id.
     *
     * @var Id|null
     */
    protected ?Id $id = null;

    /**
     * Item ParentId ValueObject.
     *
     * @var ParentId
     */
    private ParentId $parentId;

    /**
     * Item Name ValueObject.
     *
     * @var Name
     */
    private Name $name;

    /**
     * Item Status ValueObject.
     *
     * @var Status
     */
    private Status $status;

    /**
     * Item Url ValueObject.
     *
     * @var Url|null
     */
    private ?Url $url = null;

    /**
     * Item CreatedAt ValueObject.
     *
     * @var CreatedAt|null
     */
    private ?CreatedAt $createdAt = null;

    /**
     * Item UpdatedAt ValueObject.
     *
     * @var UpdatedAt|null
     */
    private ?UpdatedAt $updatedAt = null;

    /**
     * ItemEntity constructor.
     *
     * @param EventFactory|null $eventFactory
     */
    public function __construct(?EventFactory $eventFactory = null)
    {
        $this->eventFactory = $eventFactory ?: new EventFactory();
    }

    /**
     * Factory method for create new ItemEntity object.
     *
     * @param ProcessUuid       $processUuid
     * @param Uuid              $uuid
     * @param ItemValueObject   $itemValueObject
     * @param EventFactory|null $eventFactory
     *
     * @return ItemEntity
     */
    public static function create(
        ProcessUuid $processUuid,
        Uuid $uuid,
        ItemValueObject $itemValueObject,
        ?EventFactory $eventFactory = null
    ): self {
        $itemEntity = new self($eventFactory);
        $itemEntity->apply($itemEntity->eventFactory->makeItemWasCreatedEvent($processUuid, $uuid, $itemValueObject));

        return $itemEntity;
    }

    /**
     * Apply event ItemWasCreatedEvent.
     *
     * @param ItemWasCreatedEvent $event
     *
     * @throws ValueObjectInvalidException
     *
     * @suppress PhanTypeMismatchArgument
     * @psalm-suppress ArgumentTypeCoercion
     */
    protected function applyItemWasCreatedEvent(ItemWasCreatedEvent $event): void
    {
        $this->setNew();
        $this->processUuid = $event->getProcessUuid();
        $this->uuid = $event->getUuid();
        $this->assembleFromValueObject($event->getItem());
    }

    /**
     * Apply unique id to new Item.
     *
     * @param Id $id
     */
    public function addId(Id $id): void
    {
        $this->apply($this->eventFactory->makeItemIdWasAddedEvent($this->processUuid, $this->uuid, $id));
    }

    /**
     * Apply event ItemWasUpdatedEvent.
     *
     * @param ItemIdWasAddedEvent $event
     *
     * @throws Exception
     *
     * @suppress PhanUnusedProtectedNoOverrideMethodParameter
     * @psalm-suppress ArgumentTypeCoercion
     */
    protected function applyItemIdWasAddedEvent(ItemIdWasAddedEvent $event): void
    {
        $this->id = $event->getId();
    }

    /**
     * Update ItemEntity.
     *
     * @param ItemValueObject $itemValueObject
     */
    public function update(ItemValueObject $itemValueObject): void
    {
        $this->apply($this->eventFactory->makeItemWasUpdatedEvent($this->processUuid, $this->uuid, $itemValueObject));
    }

    /**
     * Apply event ItemWasUpdatedEvent.
     *
     * @param ItemWasUpdatedEvent $event
     *
     * @throws Exception
     *
     * @suppress PhanUnusedProtectedNoOverrideMethodParameter
     * @psalm-suppress ArgumentTypeCoercion
     */
    protected function applyItemWasUpdatedEvent(ItemWasUpdatedEvent $event): void
    {
        $this->setWasUpdated();
        $this->assembleFromValueObject($event->getItem());
    }

    /**
     * Delete item.
     */
    public function delete(): void
    {
        if ($this->isWasDeleted()) {
            return;
        }
        $this->apply($this->eventFactory->makeItemWasDeletedEvent($this->processUuid, $this->uuid));
    }

    /**
     * Apply event ItemWasDeletedEvent.
     *
     * @param ItemWasDeletedEvent $event
     *
     * @throws Exception
     *
     * @suppress PhanUnusedProtectedNoOverrideMethodParameter
     * @psalm-suppress ArgumentTypeCoercion
     */
    protected function applyItemWasDeletedEvent(ItemWasDeletedEvent $event): void
    {
        $this->setWasDeleted();
    }

    /**
     * Factory method for create actual ItemEntity object.
     *
     * @param Uuid              $uuid
     * @param ItemValueObject   $itemValueObject
     * @param EventFactory|null $eventFactory
     *
     * @return ItemEntity
     *
     * @throws ValueObjectInvalidException
     */
    public static function createActual(
        Uuid $uuid,
        ItemValueObject $itemValueObject,
        ?EventFactory $eventFactory = null
    ): self {
        $itemEntity = new self($eventFactory);
        $itemEntity->uuid = $uuid;
        $itemEntity->assembleFromValueObject($itemValueObject);

        return $itemEntity;
    }

    /**
     * Is item was updated from last time.
     *
     * @return bool
     */
    public function isWasUpdated(): bool
    {
        return $this->wasUpdated;
    }

    /**
     * Set was updated flag.
     *
     * @param bool $isWasUpdated
     *
     * @return $this
     */
    public function setWasUpdated(bool $isWasUpdated = true): self
    {
        $this->wasUpdated = $isWasUpdated;

        return $this;
    }

    /**
     * Is item was deleted.
     *
     * @return bool
     */
    public function isWasDeleted(): bool
    {
        return $this->wasDeleted;
    }

    /**
     * Set was deleted flag.
     *
     * @param bool $isWasDeleted
     *
     * @return $this
     */
    public function setWasDeleted(bool $isWasDeleted = true): self
    {
        $this->wasDeleted = $isWasDeleted;

        return $this;
    }

    /**
     * Is the new item.
     *
     * @return bool
     */
    public function isNew(): bool
    {
        return $this->isNew;
    }

    /**
     * Set item new.
     *
     * @param bool $isNew
     *
     * @return $this
     */
    public function setNew(bool $isNew = true): self
    {
        $this->isNew = $isNew;

        return $this;
    }

    /**
     * Return Uuid ValueObject.
     *
     * @return Uuid
     */
    public function getUuid(): Uuid
    {
        return $this->uuid;
    }

    /**
     * Return Id ValueObject.
     *
     * @return Id
     *
     * @suppress PhanPartialTypeMismatchReturn
     * @psalm-suppress InvalidNullableReturnType
     * @psalm-suppress NullableReturnStatement
     */
    public function getId(): Id
    {
        return $this->id;
    }

    /**
     * Return ParentId ValueObject.
     *
     * @return ParentId
     */
    public function getParentId(): ParentId
    {
        return $this->parentId;
    }

    /**
     * Return Name ValueObject.
     *
     * @return Name
     */
    public function getName(): Name
    {
        return $this->name;
    }

    /**
     * Return Status ValueObject.
     *
     * @return Status
     */
    public function getStatus(): Status
    {
        return $this->status;
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
     * Return CreateAt ValueObject.
     *
     * @return CreatedAt|null
     */
    public function getCreatedAt(): ?CreatedAt
    {
        return $this->createdAt;
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
     * Assemble entity from value object.
     *
     * @param ValueObjectInterface $valueObject
     *
     * @throws ValueObjectInvalidException
     * @suppress PhanPossiblyNullTypeMismatchProperty
     * @psalm-suppress PossiblyNullPropertyAssignmentValue
     */
    public function assembleFromValueObject(ValueObjectInterface $valueObject): void
    {
        if (!$valueObject instanceof ItemValueObject) {
            throw new ValueObjectInvalidException('ItemEntity can be assembled only with Item value object!');
        }

        if (null !== $valueObject->getId()) {
            $this->id = $valueObject->getId();
        }

        if (null !== $valueObject->getParentId()) {
            $this->parentId = $valueObject->getParentId();
        }

        if (null !== $valueObject->getName()) {
            $this->name = $valueObject->getName();
        }

        if (null !== $valueObject->getStatus()) {
            $this->status = $valueObject->getStatus();
        }

        if (null !== $valueObject->getUrl()) {
            $this->url = $valueObject->getUrl();
        }

        if (null !== $valueObject->getCreatedAt()) {
            $this->createdAt = $valueObject->getCreatedAt();
        }

        if (null !== $valueObject->getUpdatedAt()) {
            $this->updatedAt = $valueObject->getUpdatedAt();
        }
    }

    /**
     * Assemble value object from entity.
     *
     * @return ItemValueObject
     *
     * @throws Exception
     */
    public function assembleToValueObject(): ValueObjectInterface
    {
        $item = $this->normalize();

        return ItemValueObject::fromNative($item);
    }

    /**
     * Convert entity object to array.
     *
     * @return mixed[]
     *
     * @throws Exception
     */
    public function normalize(): array
    {
        $item = [];
        $item['uuid'] = $this->getUuid()->toNative();
        $item['status'] = $this->status->toNative();
        $item['parentId'] = $this->parentId->toNative();
        $item['name'] = $this->name->toNative();
        $item['status'] = $this->status->toNative();

        if (null !== $this->id) {
            $item['id'] = $this->id->toNative();
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
     * Return entity primary key value.
     *
     * @return int|string
     */
    public function getPrimaryKeyValue()
    {
        return $this->getAggregateRootId();
    }

    /**
     * Return current aggregate root unique key.
     *
     * @return string
     */
    public function getAggregateRootId(): string
    {
        return $this->uuid->toNative();
    }
}
