<?php declare(strict_types=1);

namespace Volgersnet\Monad;

use PHPUnit\Framework\TestCase;
use stdClass;
use Volgersnet\Monad\Exceptions\PropertyBindingException;

class ChainTest extends TestCase
{
    public function testInstantiating(): void
    {
        $object = new stdClass();

        $this->assertInstanceOf(Chain::class, new Chain($object));
        $this->assertInstanceOf(Chain::class, Chain::unit($object));
        $this->assertInstanceOf(Chain::class, Chain::from($object));
        $this->assertInstanceOf(Chain::class, Chain::of($object));
        $this->assertInstanceOf(Chain::class, (Chain::unit)($object));
    }

    public function testGetter(): void
    {
        $object       = new stdClass();
        $object->test = true;

        $this->assertTrue(Chain::of($object)->test->value());
    }

    public function testSetter(): void
    {
        $object       = new stdClass();
        $object->test = true;
        Chain::of($object)->test = false;

        $this->assertFalse(Chain::of($object)->test->value());
    }

    public function testExceptionOnUnknownProperty(): void
    {
        $this->expectException(PropertyBindingException::class);
        $chain = Chain::of('');
        $chain->nonExistingProperty = false;
    }

    public function testIssetPropertyExists(): void
    {
        $chain = Chain::of(new stdClass());
        $chain->name = 'test';
        $result = $chain->__isset('name');
        $this->assertTrue($result);

        $result = $chain->__isset('unknown');
        $this->assertFalse($result);
    }

    public function testMethodCallable(): void
    {
        $chain = Chain::of(new class {
            public function test(): bool {
                return true;
            }
        });

        $result = $chain->test();
        $this->assertTrue($result->value());

        $result = $chain->unknown();
        $this->assertNull($result->value());
    }
}
