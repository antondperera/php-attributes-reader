<?php

declare(strict_types=1);

namespace AntonDPerera\PHPAttributesReader\Tests\AttributesReader;

use PHPUnit\Framework\TestCase;
use PHPUnit\Framework\Attributes\DataProvider;

use AntonDPerera\PHPAttributesReader\AttributesReader;
use AntonDPerera\PHPAttributesReader\Exceptions\InvalidClassException;
use AntonDPerera\PHPAttributesReader\Exceptions\ClassNotFoundException;
use AntonDPerera\PHPAttributesReader\Exceptions\ClassAttributeNotFoundException;
use AntonDPerera\PHPAttributesReader\Tests\Fixtures\ClassAttributes\DummySimpleClass0WithoutClassAttributes;
use AntonDPerera\PHPAttributesReader\Tests\Fixtures\ClassAttributes\DummySimpleClass1WithClassAttributes;
use AntonDPerera\PHPAttributesReader\Tests\Fixtures\ClassAttributes\DummySimpleClass2WithClassAttributes;
use AntonDPerera\PHPAttributesReader\Tests\Fixtures\ClassAttributes\DummySimpleClass3WithClassAttributesAndComplexArguments;

class ClassAttributesTest extends TestCase
{
    public static function invalidClassValueProvider(): array
    {
        return [
            [''],
            [""],
            ["0"],
            [null]
        ];
    }

    #[DataProvider('invalidClassValueProvider')]
    public function testExceptionWhenInvalidClassValueGiven(?string $class = null): void
    {
        $this->expectException(InvalidClassException::class);
        new AttributesReader($class);
    }

    public static function nonExistingClassProvider(): array
    {
        return [
            ["notExistingClass"],
            ["SomeDummyNotExistingClass"],
            ["class"],
            [notExistingClass::class],
        ];
    }

    #[DataProvider('nonExistingClassProvider')]
    public function testExceptionWhenNonExistingClassGiven(?string $class = null): void
    {
        $this->expectException(ClassNotFoundException::class);
        new AttributesReader($class);
    }

    public static function classWithoutAttributesProvider(): array
    {
        return [
            [DummySimpleClass0WithoutClassAttributes::class, []],
        ];
    }

    #[DataProvider('classWithoutAttributesProvider')]
    public function testGetClassAttributesWithNoAttributesClass(string $class, mixed $expected): void
    {
        $reader = new AttributesReader($class);
        $attributes = $reader->getClassAttributes();
        $this->assertSame($expected, $attributes);
    }

    public static function classProviderForHasAttributes(): array
    {
        return [
            [DummySimpleClass0WithoutClassAttributes::class, false],
            [DummySimpleClass1WithClassAttributes::class, true],
            [DummySimpleClass2WithClassAttributes::class, true],
            [DummySimpleClass3WithClassAttributesAndComplexArguments::class, true],
        ];
    }

    #[DataProvider('classProviderForHasAttributes')]
    public function testHasClassAttributes(string $class, mixed $expected): void
    {
        $reader = new AttributesReader($class);
        $attributes = $reader->hasClassAttributes();
        $this->assertSame($expected, $attributes);
    }

    public static function classAttributesWithoutArgumentsProvider(): array
    {
        return [
            [DummySimpleClass1WithClassAttributes::class, 'TestAttribute', []],
            [DummySimpleClass2WithClassAttributes::class, 'TestAttribute3', []],
            [DummySimpleClass2WithClassAttributes::class, 'TestAttribute4', []],
            [DummySimpleClass3WithClassAttributesAndComplexArguments::class, 'TestAttribute14', []],
        ];
    }

    #[DataProvider('classAttributesWithoutArgumentsProvider')]
    public function testGetClassAttributesWithoutArguments(string $class, string $attribute_name, mixed $expected): void
    {
        $reader = new AttributesReader($class);
        $attribute = $reader->getClassAttributes()[$attribute_name];
        $actual = $attribute->getArguments();
        $this->assertSame($expected, $actual);
    }

    public static function classAttributesWithArgumentsProvider(): array
    {
        return [
            [DummySimpleClass1WithClassAttributes::class, 'TestAttribute2', 0, 'abc'],
            [DummySimpleClass2WithClassAttributes::class, 'TestAttribute5', 0, ''],
            [DummySimpleClass2WithClassAttributes::class, 'TestAttribute6', 0, 0],
            [DummySimpleClass2WithClassAttributes::class, 'TestAttribute7', 0, 'abc'],
            [DummySimpleClass3WithClassAttributesAndComplexArguments::class, 'TestAttribute10', 0, (object)["property1" => "property1 value"]],
            [DummySimpleClass3WithClassAttributesAndComplexArguments::class, 'TestAttribute11', 0, ["key1" => "key1 value"]],
            [DummySimpleClass3WithClassAttributesAndComplexArguments::class, 'TestAttribute12', 0, 10.13],
            [DummySimpleClass3WithClassAttributesAndComplexArguments::class, 'TestAttribute13', 0, 123],
            [DummySimpleClass3WithClassAttributesAndComplexArguments::class, 'TestAttribute15', 0, ["value1", "value2"]],
        ];
    }

    #[DataProvider('classAttributesWithArgumentsProvider')]
    public function testGetClassAttributesWithArguments(string $class, string $attribute_name, int $argument_index, mixed $expected): void
    {
        $reader = new AttributesReader($class);
        $attribute = $reader->getClassAttributes()[$attribute_name];
        $argument = $attribute->getArguments()[$argument_index];
        $this->assertEquals($expected, $argument->getValue());
    }

    public static function getClassAttributeByAttributeNameNotExistingAttributeDataProvider(): array
    {
        return [
            [DummySimpleClass1WithClassAttributes::class, 'TestAttribute1'],
        ];
    }

    #[DataProvider('getClassAttributeByAttributeNameNotExistingAttributeDataProvider')]
    public function testExceptionWhenNonExistingAttributeNameGiven(string $class = null, string $attribute_name): void
    {
        $this->expectException(ClassAttributeNotFoundException::class);
        $reader = new AttributesReader($class);
        $reader->getClassAttribute($attribute_name);
    }

    public static function getClassAttributeByAttributeNameWithExistingAttributeNameDataProvider(): array
    {
        return [
            [

                DummySimpleClass1WithClassAttributes::class,
                'TestAttribute',
                'TestAttribute',
            ],
            [
                DummySimpleClass2WithClassAttributes::class,
                'TestAttribute3',
                'TestAttribute3'
            ],
            [
                DummySimpleClass2WithClassAttributes::class,
                'TestAttribute7',
                'TestAttribute7'
            ],
            [
                DummySimpleClass3WithClassAttributesAndComplexArguments::class,
                'TestAttribute10',
                'TestAttribute10'
            ],
            [
                DummySimpleClass3WithClassAttributesAndComplexArguments::class,
                'TestAttribute15',
                'TestAttribute15'
            ],
        ];
    }

    #[DataProvider('getClassAttributeByAttributeNameWithExistingAttributeNameDataProvider')]
    public function testGetClassAttributeByAttributeName(string $class, string $attribute_name, mixed $expected): void
    {
        $reader = new AttributesReader($class);
        $actual = ($reader->getClassAttribute($attribute_name))->getName();
        $this->assertSame($expected, $actual);
    }
}
