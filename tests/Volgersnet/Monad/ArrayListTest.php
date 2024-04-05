<?php declare(strict_types=1);

namespace Volgersnet\Monad;

use PHPUnit\Framework\TestCase;

class ArrayListTest extends TestCase
{
    public function testUnitFailure(): void
    {
        $this->expectException('InvalidArgumentException');
        ArrayList::unit('abc');
    }

    public function testInstantiating(): void
    {
        $this->assertInstanceOf(ArrayList::class, new ArrayList([]));
        $this->assertInstanceOf(ArrayList::class, ArrayList::from([]));
        $this->assertInstanceOf(ArrayList::class, (ArrayList::unit)([]));
    }

    public function testValue(): void
    {
        $this->assertEquals([], ArrayList::from([])->value());
        $this->assertEquals([], ArrayList::from([])());
    }

    public function testSomething(): void
    {
        $value = [1,2,3];

        $this->assertEquals(
            [6],
            ArrayList::from(Maybe::from($value))
            ->then(static fn ($v): array => $v)
            ->map(static fn($v): int => $v * 2)
            ->filter(static fn($v): bool => $v > 4)
            ->value()
        );
    }

    public function testBind(): void
    {
        // Test bind
        $this->assertEquals(
            [1, 2, 3],
            ArrayList::from([1, 2, 3])
                ->bind(Maybe::unit)
                ->bind('implode')
                ->bind('str_split')
                ->bind(ArrayList::unit)
                ->value(),
        );
    }

    public function testMap(): void
    {
        $this->assertEquals(
            ArrayList::unit([2, 4, 6]),
            ArrayList::unit([1, 2, 3])->map(fn($value): int => $value * 2),
        );
    }

    public function testWalk(): void
    {
        $compare = [1, 2, 3];
        $called  = [1 => false, 2 => false, 3 => false];

        // Assert that $compare isn't mutated
        $this->assertEquals(
            ArrayList::unit($compare),
            ArrayList::unit($compare)->each(function ($value) use (&$called): void {
                $called[$value] = true;
            }),
        );

        // Assert that $called is mutated
        foreach ($compare as $index) {
            $this->assertTrue($called[$index]);
        }
    }

    public function testFilter(): void
    {
        $this->assertEquals(
            [1, 1, 1],
            ArrayList::unit([7, 1, 9, 1, 22, 92, 1])
                ->filter(fn($value): bool => $value === 1)
                ->value(),
        );
    }

    public function testSort(): void
    {
        $ascending = function ($a, $b) {
            if ($a === $b) {
                return 0;
            }

            return ($a < $b) ? -1 : 1;
        };

        $this->assertEquals(
            [1, 2, 4, 7, 9],
            ArrayList::from([4, 2, 7, 1, 9])
                ->sort($ascending)
                ->value()
        );
    }

    public function testComposable(): void
    {
        $doubled = ArrayList::from([1, 2, null, 3])
            ->map(static fn($value): Monad => Maybe::from($value))
            ->map(static fn($value) => $value * 2);

        $this->assertEquals(
            [2, 4, null, 6],
            $doubled->value()
        );
    }
}
