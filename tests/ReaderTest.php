<?php

declare(strict_types=1);

namespace AntonDPerera\PHPAttributesReader\Tests;

use PHPUnit\Framework\TestCase;
use AntonDPerera\PHPAttributesReader\Reader;
use AntonDPerera\PHPAttributesReader\Exceptions\InvalidClassException;
use AntonDPerera\PHPAttributesReader\Exceptions\ClassNotFoundException;
use AntonDPerera\PHPAttributesReader\Tests\Fixtures\DummySimpleClass0WithoutClassAttributes;
use AntonDPerera\PHPAttributesReader\Tests\Fixtures\DummySimpleClass1WithClassAttributes;
use AntonDPerera\PHPAttributesReader\Tests\Fixtures\DummySimpleClass2WithClassAttributes;
use AntonDPerera\PHPAttributesReader\Tests\Fixtures\DummySimpleClass3WithClassAttributesAndComplexArguments;

class ReaderTest extends TestCase
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
}
