<?php declare(strict_types=1);

namespace Volgersnet\Monad;

use PHPUnit\Framework\TestCase;

class IdentityTest extends TestCase
{
    public function testInstantiating(): void
    {
        $this->assertInstanceOf(Identity::class, new Identity(1));
        $this->assertInstanceOf(Identity::class, Identity::unit(1));
        $this->assertInstanceOf(Identity::class, (Identity::unit)(1));
    }
}
