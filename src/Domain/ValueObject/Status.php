<?php

declare(strict_types=1);

namespace Jtrw\Micro\Poc\Rpc\Domain\ValueObject;

use Backend\Api\RpcSkeleton\Domain\Exception\StatusInvalidException;
use MicroModule\ValueObject\Number\Integer;

/**
 * Class Status.
 */
class Status extends Integer
{
    public const ITEM_STATUS_ACTIVE = 1;
    public const ITEM_STATUS_INACTIVE = 0;

    private const ALLOWED_STATUSES = [
        self::ITEM_STATUS_ACTIVE,
        self::ITEM_STATUS_INACTIVE,
    ];

    /**
     * Status constructor.
     *
     * @param int $status
     *
     * @throws StatusInvalidException
     */
    public function __construct(int $status)
    {
        if (!in_array($status, self::ALLOWED_STATUSES, true)) {
            throw new StatusInvalidException(sprintf('Status \'%s\' not allowed', (string) $status));
        }

        parent::__construct($status);
    }

    /**
     * Is status active.
     *
     * @return bool
     */
    public function isActive(): bool
    {
        return self::ITEM_STATUS_ACTIVE === $this->value;
    }

    /**
     * Increment value.
     *
     * @return $this
     *
     * @phan-suppress PhanParamSignatureRealMismatchReturnType
     */
    public function inc(): self
    {
        return $this;
    }

    /**
     * Decrement value.
     *
     * @return $this
     *
     * @phan-suppress PhanParamSignatureRealMismatchReturnType
     */
    public function decr(): self
    {
        return $this;
    }
}
