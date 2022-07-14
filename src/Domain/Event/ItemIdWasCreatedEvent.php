<?php

declare(strict_types=1);

namespace Jtrw\Micro\Poc\Rpc\Domain\Event;

use Assert\Assertion;
use Assert\AssertionFailedException;
use Exception;
use Jtrw\Micro\Poc\Rpc\Domain\ValueObject\Id;
use Jtrw\Micro\Poc\Rpc\Domain\ValueObject\Uuid;
use MicroModule\ValueObject\Identity\UUID as ProcessUuid;

/**
 * Class ItemIdWasCreatedEvent.
 *
 * @category Domain\Event
 * @sub-package Item
 */
class ItemIdWasCreatedEvent extends ItemEvent
{
    /**
     * Id ValueObject.
     *
     * @var Id
     */
    private Id $id;

    /**
     * ItemWasInit constructor.
     *
     * @param ProcessUuid $processUuid
     * @param Uuid        $itemUuid
     * @param Id          $itemId
     */
    public function __construct(ProcessUuid $processUuid, Uuid $itemUuid, Id $itemId)
    {
        parent::__construct($processUuid, $itemUuid);

        $this->id = $itemId;
    }

    /**
     * Return Id.
     *
     * @return Id
     */
    public function getId(): Id
    {
        return $this->id;
    }

    /**
     * Initialize event from data array.
     *
     * @param mixed[] $data
     *
     * @return static
     *
     * @throws AssertionFailedException
     * @throws Exception
     *
     * @suppress PhanTypeMismatchArgument, PhanTypeInvalidThrowsIsInterface
     * @psalm-suppress ArgumentTypeCoercion
     */
    public static function deserialize(array $data): ItemEvent
    {
        Assertion::keyExists($data, 'process_uuid');
        Assertion::keyExists($data, 'uuid');
        Assertion::keyExists($data, 'id');

        return new static(
            ProcessUuid::fromNative($data['process_uuid']),
            Uuid::fromNative($data['uuid']),
            Id::fromNative((int) $data['id'])
        );
    }

    /**
     * Convert event object to array.
     *
     * @return mixed[]
     */
    public function serialize(): array
    {
        return [
            'process_uuid' => $this->getProcessUuid()->toNative(),
            'uuid' => $this->getUuid()->toNative(),
            'id' => $this->getId()->toNative(),
        ];
    }
}
