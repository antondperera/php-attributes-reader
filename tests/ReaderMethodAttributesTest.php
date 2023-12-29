<?php

declare(strict_types=1);

namespace AntonDPerera\PHPAttributesReader\Tests;

use PHPUnit\Framework\TestCase;
use AntonDPerera\PHPAttributesReader\AttributesReader;
use AntonDPerera\PHPAttributesReader\Tests\Fixtures\MethodAttributes\DummyClass0WithoutMethodAttributes;
use AntonDPerera\PHPAttributesReader\Tests\Fixtures\MethodAttributes\DummyClass1WithMethodAttributes;
use AntonDPerera\PHPAttributesReader\Tests\Fixtures\MethodAttributes\DummyClass2WithMethodAttributes;
use AntonDPerera\PHPAttributesReader\Exceptions\MethodNotFoundException;
use AntonDPerera\PHPAttributesReader\Exceptions\MethodAttributeNotFoundException;

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
        $reader = new AttributesReader($class);
        $attributes = $reader->getMethodAttributes();
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
        $reader = new AttributesReader($class);
        $actual = ($reader->getMethodAttributes()[$method_name][$attribute_name])->getName();
        $this->assertSame($expected, $actual);
    }

    public static function getMethodAttributesWithNonExistingMethodNameDataProvider(): array
    {
        return [[DummyClass1WithMethodAttributes::class, 'nonexistingMethod']];
    }

    /**
     * @dataProvider getMethodAttributesWithNonExistingMethodNameDataProvider
     */
    public function testgetMethodAttributesWithNonExistingMethodName(string $class, string $method_name): void
    {
        $reader = new AttributesReader($class);
        $this->expectException(MethodNotFoundException::class);
        $reader->getMethodAttributes($method_name);
    }

    public static function getMethodAttributesWithExistingMethodNameDataProvider(): array
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
     * @dataProvider getMethodAttributesWithExistingMethodNameDataProvider
     */
    public function testgetMethodAttributesWithExistingMethodName(string $class, string $method_name, string $attribute_name, mixed $expected): void
    {
        $reader = new AttributesReader($class);
        $actual = ($reader->getMethodAttributes($method_name)[$attribute_name])->getName();
        $this->assertSame($expected, $actual);
    }

    public static function getMethodAttributeWithNonExistingMethodNameDataProvider(): array
    {
        return [[DummyClass1WithMethodAttributes::class, 'nonexistingMethod', 'TestAttribute2']];
    }

    /**
     * @dataProvider getMethodAttributeWithNonExistingMethodNameDataProvider
     */
    public function testGetMethodAttributeByMethodNameWithNonExistingMethodName(string $class, string $method_name, string $attribute_name): void
    {
        $reader = new AttributesReader($class);
        $this->expectException(MethodNotFoundException::class);
        $reader->getMethodAttribute($method_name, $attribute_name);
    }

    public static function getMethodAttributeWithNonExistingAttributeNameDataProvider(): array
    {
        return [[DummyClass1WithMethodAttributes::class, 'getDummyMethod2WithAttributes', 'TestAttribute11']];
    }

    /**
     * @dataProvider getMethodAttributeWithNonExistingAttributeNameDataProvider
     */
    public function testGetMethodAttributeByMethodNameWithNonExistingAttributeName(string $class, string $method_name, string $attribute_name): void
    {
        $reader = new AttributesReader($class);
        $this->expectException(MethodAttributeNotFoundException::class);
        $reader->getMethodAttribute($method_name, $attribute_name);
    }

    public static function getMethodAttributeWithExistingMethodNameDataProvider(): array
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
     * @dataProvider getMethodAttributeWithExistingMethodNameDataProvider
     */
    public function testgetMethodAttributeWithExistingMethodName(string $class, string $method_name, string $attribute_name, mixed $expected): void
    {
        $reader = new AttributesReader($class);
        $actual = ($reader->getMethodAttribute($method_name,$attribute_name))->getName();
        $this->assertSame($expected, $actual);
    }
}
