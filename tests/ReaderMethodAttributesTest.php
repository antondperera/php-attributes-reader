<?php

declare(strict_types=1);

namespace AntonDPerera\PHPAttributesReader\Tests;

use PHPUnit\Framework\TestCase;
use AntonDPerera\PHPAttributesReader\Reader;
use AntonDPerera\PHPAttributesReader\Tests\Fixtures\MethodAttributes\DummyClass0WithoutMethodAttributes;
use AntonDPerera\PHPAttributesReader\Tests\Fixtures\MethodAttributes\DummyClass1WithMethodAttributes;

class ReaderMethodAttributesTest extends TestCase
{
    public static function classesWithoutMethodAttributesProvider(): array
    {
        return [
            [DummyClass0WithoutMethodAttributes::class, []],
        ];
    }

    /**
     * @dataProvider classesWithoutMethodAttributesProvider
     */
    public function testGetAllMethodAttributesWithNoAttributes(string $class, mixed $expected): void
    {
        $reader = new Reader($class);
        $attributes = $reader->getAllMethodAttributes();
        $this->assertSame($expected, $attributes);
    }

    public static function classesWithMethodAttributesProvider(): array
    {
        return [
            [
                DummyClass1WithMethodAttributes::class,
                'getDummyMethod2WithAttributes',
                'TestAttribute',
                0,
                'TestAttribute'
            ],
        ];
    }

    /**
     * @dataProvider classesWithMethodAttributesProvider
     */
    public function testGetAllMethodAttributesWithAttributes(string $class, string $method_name, string $attribute_name, int $attribute_index, mixed $expected): void
    {
        $reader = new Reader($class);
        $actual = ($reader->getAllMethodAttributes()[$method_name][$attribute_name][$attribute_index])->getName();
        $this->assertSame($expected, $actual);
    }
}
