<?php declare(strict_types=1);

namespace Volgersnet\Monad\Traits;

/**
 * @template MonadType
 */
trait Of
{
    /**
     * Wraps the value in the monad datatype
     *
     * @return MonadType
     */
    public static function of(mixed $value)
    {
        return self::unit($value);
    }
}
