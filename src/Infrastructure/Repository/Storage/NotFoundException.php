<?php

declare(strict_types=1);

namespace Jtrw\Micro\Poc\Rpc\Infrastructure\Repository\Storage;

use RuntimeException;

/**
 * Exception thrown if an event stream is not found.
 */
final class NotFoundException extends RuntimeException
{
}
