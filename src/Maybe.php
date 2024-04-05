<?php declare(strict_types=1);

namespace Volgersnet\Monad;

use Volgersnet\Monad\Traits\From;
use Volgersnet\Monad\Traits\Then;

class Maybe extends Monad
{
    /** @use Then<Monad> */
    use Then;

    /** @use From<Monad> */
    use From;

    public const unit = 'Volgersnet\Monad\Maybe::unit';

    public function bind(callable $callback, mixed ...$arguments): Monad
    {
        return null === $this->_value
            ? self::unit(null)
            : parent::bind($callback, ...$arguments);
    }
}
