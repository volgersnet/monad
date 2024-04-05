<?php declare(strict_types=1);

namespace Volgersnet\Monad\Exceptions;

use RuntimeException;

class PropertyBindingException extends RuntimeException
{
    public function __construct(string $name, mixed $object)
    {
        $objectInfo = is_object($object) ? ' Object: ' . get_debug_type($object) : '';

        $errorMessage = sprintf(
            "Failed to bind property '%s' on %s.%s",
            $name,
            get_debug_type($object),
            $objectInfo
        );

        parent::__construct($errorMessage);
    }
}
