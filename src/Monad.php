<?php declare(strict_types=1);

namespace Volgersnet\Monad;

use Volgersnet\Monad\Traits\From;
use Volgersnet\Monad\Traits\Then;

abstract class Monad implements MonadInterface
{
    /** @use Then<MonadInterface> */
    use Then;
    /** @use From<MonadInterface> */
    use From;

    public function __construct(
        protected mixed $_value
    ) {
    }

    /**
     * Wraps the value in the monad datatype
     */
    public static function unit(mixed $value): self
    {
        return new static($value);
    }

    /**
     * Applies the callback to the wrapped value,
     * injecting the wrapped value at the head of the argument stack.
     *
     * @param callable $callback The callback function to be executed.
     * @param mixed ...$arguments Additional arguments to be passed to the callback function.
     *
     * @return self|static
     */
    public function bind(callable $callback, mixed ...$arguments): self|static
    {
        return $this->_value instanceof self
            ? $this->_value->bind($callback, ...$arguments)
            : self::unit(
                $callback($this->_value, ...$arguments)
            );
    }

    /**
     * Applies the callback to the wrapped value,
     * injecting the wrapped value as argument at the tail of the argument stack.
     *
     * @param callable $callback The callback function to be executed.
     * @param mixed ...$arguments Additional arguments to be passed to the callback function.
     *
     * @return self
     */
    public function bindRight(callable $callback, mixed ...$arguments): self {
        return $this->_value instanceof self
            ? $this->_value->bind($callback, ...$arguments)
            : self::unit(
                $callback(...[...$arguments, $this->_value])
            );
    }

    /**
     * Executes a callback function, passing the wrapped value as the first argument
     * and any additional arguments provided, discarding the result.
     *
     * @param callable $callback The callback function to be executed.
     * @param mixed ...$arguments Additional arguments to be passed to the callback function.
     *
     * @return self
     */
    public function tap(callable $callback, mixed ...$arguments): self
    {
        $this->_value instanceof self
            ? $this->_value->tap($callback, ...$arguments)
            : $callback($this->_value, ...$arguments);

        return $this;
    }

    /**
     * Executes a callback function, passing the wrapped value as the last argument
     * and any additional arguments provided, discarding the result.
     *
     * @param callable $callback The callback function to be executed.
     * @param mixed ...$arguments Additional arguments to be passed to the callback function.
     *
     * @return self
     */
    public function tapRight(callable $callback, mixed ...$arguments): self
    {
        $this->_value instanceof self
            ? $this->_value->tapRight($callback, ...$arguments)
            : $callback(...[...$arguments, $this->_value]);

        return $this;
    }

    public function value(): mixed
    {
        return $this->_value instanceof self
            ? $this->_value->value()
            : $this->_value;
    }

    public function __invoke(): mixed
    {
        return $this->value();
    }
}
