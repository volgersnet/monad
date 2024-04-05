<?php declare(strict_types=1);

namespace Volgersnet\Monad\Traits;

/**
 * @template MonadType
 */
trait From
{
    /**
     * Wraps the value in the monad datatype
     *
     * @return MonadType
     */
    public static function from(mixed $value)
    {
        return self::unit($value);
    }
}
