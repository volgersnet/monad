<?php declare(strict_types=1);

namespace Volgersnet\Monad\Test;

use PHPUnit\Framework\TestCase;
use Volgersnet\Monad\Identity;
use Volgersnet\Monad\Maybe;

class MaybeTest extends TestCase
{
    public function testInstantiating(): void
    {
        $this->assertInstanceOf(Maybe::class, new Maybe(1));
        $this->assertInstanceOf(Maybe::class, Maybe::unit(1));
        $this->assertInstanceOf(Maybe::class, Maybe::from(1));
        $this->assertInstanceOf(Maybe::class, (Maybe::unit)(1));
    }

    public function testValue(): void
    {
        $this->assertEquals(1, Maybe::from(1)->value());
        $this->assertEquals(1, Maybe::from(1)());
    }

    public function testBind(): void
    {
        // Test bind
        $this->assertEquals(
            Maybe::from('ABC'),
            Maybe::from('abc')->bind('strtoupper')
        );

        // Test then
        $this->assertEquals(
            Maybe::from('abc'),
            Maybe::from('ABC')->then('strtolower')
        );

        /*
         * If a Maybe holds null, it shouldn't execute the bind.
         * $called is set to 'true' by reference if the bind is executed.
         */
        $called = false;

        $this->assertEquals(
            Maybe::from(null),
            Maybe::from(null)->bind(function () use (&$called) {
                $called = true;
            })
        );
        $this->assertFalse($called);
    }

    public function testUnit(): void
    {
        $this->assertNotEquals(
            $maybe = Maybe::unit(1),
            Maybe::unit($maybe)
        );
    }

    public function testBindRightMethodAppliesCallbackAndReturnsNewInstance(): void
    {
        $monad = Maybe::from(Maybe::from(5));

        $callback = fn($value, $additional) => $value + $additional;

        $result = $monad->bindRight($callback, 10);

        $this->assertEquals(15, $result->value());
    }

    public function testTapMethodExecutesCallbackAndDoesNotMutateValue(): void
    {
        $string = 'A';
        $monad  = Maybe::from(Identity::from($string));

        // Try mutating the data
        $result = $monad->tap(function($a, $b) {

            // Tests right binding
            $this->assertEquals('AB',  $a . $b);

        }, 'B');

        //  Assert mutation didn't apply
        $this->assertEquals($string, $result->value());
    }

    public function testTapRightMethodExecutesCallbackAndDoesNotMutateValue(): void
    {
        $string = 'A';
        $monad  = Maybe::from(Maybe::from($string));

        // Try mutating the data
        $result = $monad->tapRight(function($a, $b) {
            // Tests right binding
           $this->assertEquals('BA',  $a . $b);

        }, 'B');

        //  Assert mutation didn't apply
        $this->assertEquals($string, $result->value());
    }

    public function testValueMethodReturnsWrappedValue(): void
    {
        $value = 'test';
        $monad = Maybe::from($value);

        $result = $monad->value();

        $this->assertEquals($value, $result);
    }

}
