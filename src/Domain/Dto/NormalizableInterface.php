<?php

declare(strict_types=1);

namespace Jtrw\Micro\Poc\Rpc\Domain\Dto;

/**
 * Interface NormalizeInterface.
 */
interface NormalizableInterface
{
    /**
     * Convert array to dto object.
     *
     * @param mixed[] $data
     *
     * @return mixed
     */
    public static function denormalize(array $data);

    /**
     * Convert object dto to array.
     *
     * @return mixed[]
     */
    public function normalize(): array;
}
