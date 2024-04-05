<?php declare(strict_types=1);

namespace Volgersnet\Monad;

interface MonadInterface
{
    /**
     * Takes a value to store inside the monad datatype.
     * @param mixed $_value
     */
    public function __construct(mixed $_value);

    /**
     * Returns the value stored inside the monad datatype.
     * @return mixed
     */
    public function value(): mixed;
}
