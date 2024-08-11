<?php

declare(strict_types=1);

namespace Volgersnet\Monad;

use InvalidArgumentException;
use Traversable;
use Volgersnet\Monad\Traits\From;
use Volgersnet\Monad\Traits\Then;

class ArrayList extends Monad
{
    /** @use Then<\Volgersnet\Monad\ArrayList> */
    use Then;

    /** @use From<\Volgersnet\Monad\ArrayList> */
    use From;

    public const unit = 'Volgersnet\Monad\ArrayList::unit';

    public function __construct(mixed $_value)
    {

        if (!($_value instanceof MonadInterface) &&
            !is_array($_value) &&
            !($_value instanceof Traversable)
        ) {
            throw new InvalidArgumentException('Must be traversable');
        }

        parent::__construct($_value);
    }

    /**
     * Wraps the value in the monad datatype
     */
    public static function unit(mixed $value): self
    {
        return $value instanceof MonadInterface
            ? new static($value->value())
            : new static($value);
    }

    /**
     * Apply a user supplied function to every member of the wrapped traversable without mutating it
     */
    public function each(callable $callback, mixed ...$arguments): self
    {
        foreach ($this->value() as $value) {
            $callback($value, ...$arguments);
        }

        return $this;
    }

    /**
     * Applies the callback to the elements of the wrapped traversable
     */
    public function map(callable $callback, mixed ...$arguments): self
    {
        $aggregation = [];

        foreach ($this->value() as $value) {
            $aggregation[] = $callback($value, ...$arguments);
        }

        return self::unit($aggregation);
    }

    /**
     * Filters elements of the wrapped traversable using a callback function
     */
    public function filter(callable $callback): self
    {
        $aggregation = [];

        foreach ($this->value() as $index => $value) {
            if ($callback($value, $index, $this->_value)) {
                $aggregation[$index] = $value;
            }
        }

        return self::unit($aggregation);
    }

    /**
     * Sort the wrapped traversable by values using a user-defined comparison function
     */
    public function sort(callable $callback, bool $preserveKeys = false): self
    {
        $array = $this->value();

        ($preserveKeys ? 'uasort' : 'usort')($array, static fn($left, $right): int => $callback($left, $right, $array));

        return self::unit($array);
    }

    /**
     * @return array<int, mixed> The wrapped array
     */
    public function value(): array
    {
        $aggregate = [];

        foreach (parent::value() as $value) {
            $value instanceof Monad
                ? $aggregate[] = $value->value()
                : $aggregate[] = $value;
        }

        return $aggregate;
    }
}
