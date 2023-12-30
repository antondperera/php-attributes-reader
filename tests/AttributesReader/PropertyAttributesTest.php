<?php

declare(strict_types=1);

namespace AntonDPerera\PHPAttributesReader\Tests\AttributesReader;

use PHPUnit\Framework\TestCase;
use PHPUnit\Framework\Attributes\DataProvider;

use AntonDPerera\PHPAttributesReader\AttributesReader;
use AntonDPerera\PHPAttributesReader\Tests\Fixtures\PropertyAttributes\DummyClass0WithoutPropertyAttributes;
use AntonDPerera\PHPAttributesReader\Tests\Fixtures\PropertyAttributes\DummyClass1WithPropertyAttributes;
use AntonDPerera\PHPAttributesReader\Tests\Fixtures\PropertyAttributes\DummyClass2WithPropertyAttributes;
use AntonDPerera\PHPAttributesReader\Exceptions\PropertyNotFoundException;
use AntonDPerera\PHPAttributesReader\Exceptions\PropertyAttributeNotFoundException;

class PropertyAttributesTest extends TestCase
{
    public static function classesWithoutPropertyAttributesProvider(): array
    {
        return [
            [DummyClass0WithoutPropertyAttributes::class, []],
        ];
    }

    #[DataProvider('classesWithoutPropertyAttributesProvider')]
    public function testGetAllPropertyAttributesWithNoAttributes(string $class, mixed $expected): void
    {
        $reader = new AttributesReader($class);
        $attributes = $reader->getPropertyAttributes();
        $this->assertSame($expected, $attributes);
    }

    public static function classesWithPropertyAttributesProvider(): array
    {
        return [
            [
                DummyClass1WithPropertyAttributes::class,
                'property2_with_attributes',
                'TestAttribute',
                'TestAttribute'
            ],
            [
                DummyClass1WithPropertyAttributes::class,
                'property2_with_attributes',
                'TestAttribute2',
                'TestAttribute2'
            ],
            [
                DummyClass2WithPropertyAttributes::class,
                'property3_with_attributes',
                'TestAttribute3',
                'TestAttribute3'
            ],
        ];
    }

    #[DataProvider('classesWithPropertyAttributesProvider')]
    public function testGetAllPropertyAttributesWithAttributes(string $class, string $property_name, string $attribute_name, mixed $expected): void
    {
        $reader = new AttributesReader($class);
        $actual = ($reader->getPropertyAttributes()[$property_name][$attribute_name])->getName();
        $this->assertSame($expected, $actual);
    }

    public static function getPropertyAttributesWithNonExistingPropertyNameDataProvider(): array
    {
        return [[DummyClass1WithPropertyAttributes::class, 'nonexistingProperty']];
    }

    #[DataProvider('getPropertyAttributesWithNonExistingPropertyNameDataProvider')]
    public function testgetPropertyAttributesWithNonExistingPropertyName(string $class, string $property_name): void
    {
        $reader = new AttributesReader($class);
        $this->expectException(PropertyNotFoundException::class);
        $reader->getPropertyAttributes($property_name);
    }

    public static function getPropertyAttributesWithExistingPropertyNameDataProvider(): array
    {
        return [
            [

                DummyClass1WithPropertyAttributes::class,
                'property2_with_attributes',
                'TestAttribute',
                'TestAttribute',
            ],
            [
                DummyClass1WithPropertyAttributes::class,
                'property2_with_attributes',
                'TestAttribute2',
                'TestAttribute2'
            ],
            [
                DummyClass2WithPropertyAttributes::class,
                'property3_with_attributes',
                'TestAttribute3',
                'TestAttribute3'
            ],
        ];
    }

    #[DataProvider('getPropertyAttributesWithExistingPropertyNameDataProvider')]
    public function testgetPropertyAttributesWithExistingPropertyName(string $class, string $property_name, string $attribute_name, mixed $expected): void
    {
        $reader = new AttributesReader($class);
        $actual = ($reader->getPropertyAttributes($property_name)[$attribute_name])->getName();
        $this->assertSame($expected, $actual);
    }

    public static function getPropertyAttributeWithNonExistingPropertyNameDataProvider(): array
    {
        return [[DummyClass1WithPropertyAttributes::class, 'nonexistingProperty', 'TestAttribute2']];
    }

    #[DataProvider('getPropertyAttributeWithNonExistingPropertyNameDataProvider')]
    public function testGetPropertyAttributeByPropertyNameWithNonExistingPropertyName(string $class, string $property_name, string $attribute_name): void
    {
        $reader = new AttributesReader($class);
        $this->expectException(PropertyNotFoundException::class);
        $reader->getPropertyAttribute($property_name, $attribute_name);
    }

    public static function getPropertyAttributeWithNonExistingAttributeNameDataProvider(): array
    {
        return [[DummyClass1WithPropertyAttributes::class, 'property2_with_attributes', 'TestAttribute11']];
    }

    #[DataProvider('getPropertyAttributeWithNonExistingAttributeNameDataProvider')]
    public function testGetPropertyAttributeByPropertyNameWithNonExistingAttributeName(string $class, string $property_name, string $attribute_name): void
    {
        $reader = new AttributesReader($class);
        $this->expectException(PropertyAttributeNotFoundException::class);
        $reader->getPropertyAttribute($property_name, $attribute_name);
    }

    public static function getPropertyAttributeWithExistingPropertyNameDataProvider(): array
    {
        return [
            [

                DummyClass1WithPropertyAttributes::class,
                'property2_with_attributes',
                'TestAttribute',
                'TestAttribute',
            ],
            [
                DummyClass1WithPropertyAttributes::class,
                'property2_with_attributes',
                'TestAttribute2',
                'TestAttribute2'
            ],
            [
                DummyClass2WithPropertyAttributes::class,
                'property3_with_attributes',
                'TestAttribute3',
                'TestAttribute3'
            ],
        ];
    }

    #[DataProvider('getPropertyAttributeWithExistingPropertyNameDataProvider')]
    public function testgetPropertyAttributeWithExistingPropertyName(string $class, string $property_name, string $attribute_name, mixed $expected): void
    {
        $reader = new AttributesReader($class);
        $actual = ($reader->getPropertyAttribute($property_name, $attribute_name))->getName();
        $this->assertSame($expected, $actual);
    }
}
