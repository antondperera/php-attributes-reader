<?php

declare(strict_types=1);

namespace AntonDPerera\PHPAttributesReader\Tests;

use PHPUnit\Framework\TestCase;
use AntonDPerera\PHPAttributesReader\Reader;
use AntonDPerera\PHPAttributesReader\Exceptions\InvalidClassException;
use AntonDPerera\PHPAttributesReader\Exceptions\ClassNotFoundException;
use AntonDPerera\PHPAttributesReader\Tests\Fixtures\ClassAttributes\DummySimpleClass0WithoutClassAttributes;
use AntonDPerera\PHPAttributesReader\Tests\Fixtures\ClassAttributes\DummySimpleClass1WithClassAttributes;
use AntonDPerera\PHPAttributesReader\Tests\Fixtures\ClassAttributes\DummySimpleClass2WithClassAttributes;
use AntonDPerera\PHPAttributesReader\Tests\Fixtures\ClassAttributes\DummySimpleClass3WithClassAttributesAndComplexArguments;

class ReaderClassAttributesTest extends TestCase
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

    /**
     * @dataProvider invalidClassValueProvider
     */
    public function testExceptionWhenInvalidClassValueGiven(?string $class = null): void
    {
        $this->expectException(InvalidClassException::class);
        $reader = new Reader($class);
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

    /**
     * @dataProvider nonExistingClassProvider
     */
    public function testExceptionWhenNonExistingClassGiven(?string $class = null): void
    {
        $this->expectException(ClassNotFoundException::class);
        $reader = new Reader($class);
    }

    public static function classWithoutAttributesProvider(): array
    {
        return [
            [DummySimpleClass0WithoutClassAttributes::class, []],
        ];
    }

    /**
     * @dataProvider classWithoutAttributesProvider
     */
    public function testGetClassAttributesWithNoAttributesClass(string $class, mixed $expected): void
    {
        $reader = new Reader($class);
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

    /**
     * @dataProvider classProviderForHasAttributes
     */
    public function testHasClassAttributes(string $class, mixed $expected): void
    {
        $reader = new Reader($class);
        $attributes = $reader->hasClassAttributes();
        $this->assertSame($expected, $attributes);
    }

    public static function classAttributesWithoutArgumentsProvider(): array
    {
        return [
            [DummySimpleClass1WithClassAttributes::class, 0, []],
            [DummySimpleClass2WithClassAttributes::class, 0, []],
            [DummySimpleClass2WithClassAttributes::class, 1, []],
            [DummySimpleClass3WithClassAttributesAndComplexArguments::class, 4, []],
        ];
    }

    /**
     * @dataProvider classAttributesWithoutArgumentsProvider
     */
    public function testGetClassAttributesWithoutArguments(string $class, int $attribute_index, mixed $expected): void
    {
        $reader = new Reader($class);
        $attribute = $reader->getClassAttributes()[$attribute_index];
        $actual = $attribute->getArguments();
        $this->assertSame($expected, $actual);
    }

    public static function classAttributesWithArgumentsProvider(): array
    {
        return [
            [DummySimpleClass1WithClassAttributes::class, 1, 0, 'abc'],
            [DummySimpleClass2WithClassAttributes::class, 2, 0, ''],
            [DummySimpleClass2WithClassAttributes::class, 3, 0, 0],
            [DummySimpleClass2WithClassAttributes::class, 4, 0, 'abc'],
            [DummySimpleClass3WithClassAttributesAndComplexArguments::class, 0, 0, (object)["property1"=>"property1 value"]],
            [DummySimpleClass3WithClassAttributesAndComplexArguments::class, 1, 0, ["key1"=>"key1 value"]],
            [DummySimpleClass3WithClassAttributesAndComplexArguments::class, 2, 0, 10.13],
            [DummySimpleClass3WithClassAttributesAndComplexArguments::class, 3, 0, 123],
            [DummySimpleClass3WithClassAttributesAndComplexArguments::class, 5, 0, ["value1", "value2"]],
        ];
    }

    /**
     * @dataProvider classAttributesWithArgumentsProvider
     */
    public function testGetClassAttributesWithArguments(string $class, int $attribute_index, int $argument_index, mixed $expected): void
    {
        $reader = new Reader($class);
        $attribute = $reader->getClassAttributes()[$attribute_index];
        $argument = $attribute->getArguments()[$argument_index];
        $this->assertEquals($expected, $argument->getValue());
    }
}