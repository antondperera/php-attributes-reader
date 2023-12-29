<?php

declare(strict_types=1);

namespace AntonDPerera\PHPAttributesReader\Tests;

use PHPUnit\Framework\TestCase;
use AntonDPerera\PHPAttributesReader\Reader;
use AntonDPerera\PHPAttributesReader\Tests\Fixtures\PropertyAttributes\DummyClass0WithoutPropertyAttributes;
use AntonDPerera\PHPAttributesReader\Tests\Fixtures\PropertyAttributes\DummyClass1WithPropertyAttributes;
use AntonDPerera\PHPAttributesReader\Tests\Fixtures\PropertyAttributes\DummyClass2WithPropertyAttributes;
use AntonDPerera\PHPAttributesReader\Exceptions\PropertyNotFoundException;
use AntonDPerera\PHPAttributesReader\Exceptions\PropertyAttributeNotFoundException;

class ReaderPropertyAttributesTest extends TestCase
{
    public static function classesWithoutPropertyAttributesProvider(): array
    {
        return [
            [DummyClass0WithoutPropertyAttributes::class, []],
        ];
    }

    /**
     * @dataProvider classesWithoutPropertyAttributesProvider
     */
    public function testGetAllPropertyAttributesWithNoAttributes(string $class, mixed $expected): void
    {
        $reader = new Reader($class);
        $attributes = $reader->getPropertyAttributes();
        $this->assertSame($expected, $attributes);
    }

    public static function classesWithPropertyAttributesProvider(): array
    {
        return [
            [
                DummyClass1WithPropertyAttributes::class,
                'property2_without_attributes',
                'TestAttribute',
                'TestAttribute'
            ],
            [
                DummyClass1WithPropertyAttributes::class,
                'property2_without_attributes',
                'TestAttribute2',
                'TestAttribute2'
            ],
            [
                DummyClass2WithPropertyAttributes::class,
                'property3_without_attributes',
                'TestAttribute3',
                'TestAttribute3'
            ],
        ];
    }

    /**
     * @dataProvider classesWithPropertyAttributesProvider
     */
    public function testGetAllPropertyAttributesWithAttributes(string $class, string $property_name, string $attribute_name, mixed $expected): void
    {
        $reader = new Reader($class);
        $actual = ($reader->getPropertyAttributes()[$property_name][$attribute_name])->getName();
        $this->assertSame($expected, $actual);
    }

    public static function getPropertyAttributesWithNonExistingPropertyNameDataProvider(): array
    {
        return [[DummyClass1WithPropertyAttributes::class, 'nonexistingProperty']];
    }

    /**
     * @dataProvider getPropertyAttributesWithNonExistingPropertyNameDataProvider
     */
    public function testgetPropertyAttributesWithNonExistingPropertyName(string $class, string $property_name): void
    {
        $reader = new Reader($class);
        $this->expectException(PropertyNotFoundException::class);
        $reader->getPropertyAttributes($property_name);
    }

    public static function getPropertyAttributesWithExistingPropertyNameDataProvider(): array
    {
        return [
            [

                DummyClass1WithPropertyAttributes::class,
                'property2_without_attributes',
                'TestAttribute',
                'TestAttribute',
            ],
            [
                DummyClass1WithPropertyAttributes::class,
                'property2_without_attributes',
                'TestAttribute2',
                'TestAttribute2'
            ],
            [
                DummyClass2WithPropertyAttributes::class,
                'property3_without_attributes',
                'TestAttribute3',
                'TestAttribute3'
            ],
        ];
    }

    /**
     * @dataProvider getPropertyAttributesWithExistingPropertyNameDataProvider
     */
    public function testgetPropertyAttributesWithExistingPropertyName(string $class, string $property_name, string $attribute_name, mixed $expected): void
    {
        $reader = new Reader($class);
        $actual = ($reader->getPropertyAttributes($property_name)[$attribute_name])->getName();
        $this->assertSame($expected, $actual);
    }

    public static function getPropertyAttributeWithNonExistingPropertyNameDataProvider(): array
    {
        return [[DummyClass1WithPropertyAttributes::class, 'nonexistingProperty', 'TestAttribute2']];
    }

    /**
     * @dataProvider getPropertyAttributeWithNonExistingPropertyNameDataProvider
     */
    public function testGetPropertyAttributeByPropertyNameWithNonExistingPropertyName(string $class, string $property_name, string $attribute_name): void
    {
        $reader = new Reader($class);
        $this->expectException(PropertyNotFoundException::class);
        $reader->getPropertyAttribute($property_name, $attribute_name);
    }

    public static function getPropertyAttributeWithNonExistingAttributeNameDataProvider(): array
    {
        return [[DummyClass1WithPropertyAttributes::class, 'property2_without_attributes', 'TestAttribute11']];
    }

    /**
     * @dataProvider getPropertyAttributeWithNonExistingAttributeNameDataProvider
     */
    public function testGetPropertyAttributeByPropertyNameWithNonExistingAttributeName(string $class, string $property_name, string $attribute_name): void
    {
        $reader = new Reader($class);
        $this->expectException(PropertyAttributeNotFoundException::class);
        $reader->getPropertyAttribute($property_name, $attribute_name);
    }

    public static function getPropertyAttributeWithExistingPropertyNameDataProvider(): array
    {
        return [
            [

                DummyClass1WithPropertyAttributes::class,
                'property2_without_attributes',
                'TestAttribute',
                'TestAttribute',
            ],
            [
                DummyClass1WithPropertyAttributes::class,
                'property2_without_attributes',
                'TestAttribute2',
                'TestAttribute2'
            ],
            [
                DummyClass2WithPropertyAttributes::class,
                'property3_without_attributes',
                'TestAttribute3',
                'TestAttribute3'
            ],
        ];
    }

    /**
     * @dataProvider getPropertyAttributeWithExistingPropertyNameDataProvider
     */
    public function testgetPropertyAttributeWithExistingPropertyName(string $class, string $property_name, string $attribute_name, mixed $expected): void
    {
        $reader = new Reader($class);
        $actual = ($reader->getPropertyAttribute($property_name,$attribute_name))->getName();
        $this->assertSame($expected, $actual);
    }
}
