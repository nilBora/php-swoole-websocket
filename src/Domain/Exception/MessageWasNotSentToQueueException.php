<?php

declare(strict_types=1);

namespace Jtrw\Micro\Poc\Rpc\Domain\Exception;

use MicroModule\Base\Domain\Exception\CriticalException;

/**
 * Class MessageWasNotSentToQueueException.
 *
 * @category Domain\Exception
 */
final class MessageWasNotSentToQueueException extends CriticalException
{
}
