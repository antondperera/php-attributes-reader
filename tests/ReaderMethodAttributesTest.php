<?php

declare(strict_types=1);

namespace AntonDPerera\PHPAttributesReader\Tests;

use PHPUnit\Framework\TestCase;
use AntonDPerera\PHPAttributesReader\Reader;
use AntonDPerera\PHPAttributesReader\Tests\Fixtures\MethodAttributes\DummyClass0WithoutMethodAttributes;
use AntonDPerera\PHPAttributesReader\Tests\Fixtures\MethodAttributes\DummyClass1WithMethodAttributes;
use AntonDPerera\PHPAttributesReader\Tests\Fixtures\MethodAttributes\DummyClass2WithMethodAttributes;

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
                'TestAttribute'
            ],
            [
                DummyClass1WithMethodAttributes::class,
                'getDummyMethod2WithAttributes',
                'TestAttribute2',
                'TestAttribute2'
            ],
            [
                DummyClass2WithMethodAttributes::class,
                'getDummyMethod3WithAttributes',
                'TestAttribute3',
                'TestAttribute3'
            ],
        ];
    }

    /**
     * @dataProvider classesWithMethodAttributesProvider
     */
    public function testGetAllMethodAttributesWithAttributes(string $class, string $method_name, string $attribute_name, mixed $expected): void
    {
        $reader = new Reader($class);
        $actual = ($reader->getAllMethodAttributes()[$method_name][$attribute_name])->getName();
        $this->assertSame($expected, $actual);
    }

    public static function getMethodAttributesByMethodNameWithNonExistingMethodNameDataProvider(): array
    {
        return [
            [
                DummyClass1WithMethodAttributes::class,
                'nonexistingMethod',
                null
            ],
        ];
    }

    /**
     * @dataProvider getMethodAttributesByMethodNameWithNonExistingMethodNameDataProvider
     */
    public function testGetMethodAttributesByMethodNameWithNonExistingMethodName(string $class, string $method_name, mixed $expected): void
    {
        $reader = new Reader($class);
        $actual = ($reader->getMethodAttributesByMethodName($method_name));
        $this->assertSame($expected, $actual);
    }

    public static function getMethodAttributesByMethodNameWithExistingMethodNameDataProvider(): array
    {
        return [
            [
                
                DummyClass1WithMethodAttributes::class,
                'getDummyMethod2WithAttributes',
                'TestAttribute',
                'TestAttribute',
            ],
            [
                DummyClass1WithMethodAttributes::class,
                'getDummyMethod2WithAttributes',
                'TestAttribute2',
                'TestAttribute2'
            ],
            [
                DummyClass2WithMethodAttributes::class,
                'getDummyMethod3WithAttributes',
                'TestAttribute3',
                'TestAttribute3'
            ],
        ];
    }

    /**
     * @dataProvider getMethodAttributesByMethodNameWithExistingMethodNameDataProvider
     */
    public function testGetMethodAttributesByMethodNameWithExistingMethodName(string $class, string $method_name, string $attribute_name, mixed $expected): void
    {
        $reader = new Reader($class);
        $actual = ($reader->getMethodAttributesByMethodName($method_name)[$attribute_name])->getName();
        $this->assertSame($expected, $actual);
    }
}
