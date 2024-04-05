<?php declare(strict_types=1);

namespace Volgersnet\Monad\Traits;

use Volgersnet\Monad\Exceptions\PropertyBindingException;
use Volgersnet\Monad\Monad;

/**
 * @mixin Monad
 */
trait Accessor
{
    public function __get(string $name): ?Monad
    {
        return $this->bind(
            static fn($value) => property_exists($value, $name)
                ? $value->$name
                : null
        );
    }

    public function __set(string $name, mixed $value): void
    {
        $this->bind(static fn($object): mixed => !is_object($object)
            ? throw new PropertyBindingException($name, $object)
            : $object->$name = $value
        );
    }

    public function __isset(string $name): bool
    {
        return $this->bind(fn($object) => isset($object->$name))->value();
    }

    /**
     * @param array<int, mixed> $arguments
     */
    public function __call(string $name, array $arguments): ?monad
    {
        return $this->bind(fn($object) => method_exists($object, $name)
            ? $object->$name(...$arguments)
            : null
        );
    }
}
