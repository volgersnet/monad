<?php

declare(strict_types=1);

namespace Volgersnet\Monad\Traits;

/**
 * @template MonadType
 */
Trait Then
{
    /**
     * @param callable $callback
     * @param mixed ...$arguments
     *
     * @return MonadType;
     */
    public function then(callable $callback, mixed ...$arguments)
    {
        return $this->bind($callback, ...$arguments);
    }
}
