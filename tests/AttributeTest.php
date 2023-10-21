<?php

declare(strict_types=1);

namespace AntonDPerera\PHPAttributesReader\Tests;

use TypeError;
use ReflectionClass;
use PHPUnit\Framework\TestCase;

use AntonDPerera\PHPAttributesReader\Attribute;
use AntonDPerera\PHPAttributesReader\Tests\Fixtures\DummySimpleClass1WithClassAttributes;
use AntonDPerera\PHPAttributesReader\Tests\Fixtures\DummySimpleClass2WithClassAttributes;

class AttributeTest extends TestCase
{
    public static function invalidReflectionAttributeProvider(): array
    {
        return [
            [''],
            [""],
            ["0"],
            [null]
        ];
    }

    /**
     * @dataProvider invalidReflectionAttributeProvider
     */
    public function testExceptionWhenInvalidReflectionAttributeGiven(?string $class = null): void
    {
        $this->expectException(TypeError::class);
        new Attribute($class);
    }

    public static function dummyClassesAndExpectedValueProvider(): array
    {
        return [
            [DummySimpleClass1WithClassAttributes::class, "TestAttribute"],
            [DummySimpleClass2WithClassAttributes::class, "TestAttribute3"]
        ];
    }

    /**
     * @dataProvider dummyClassesAndExpectedValueProvider
     */
    public function testGetName(string $class, string $expected): void
    {
        $reflection = new ReflectionClass($class);
        $class_attributes = $reflection->getAttributes();
        $attribute = new Attribute($class_attributes[0]);
        $this->assertSame($expected,$attribute->getName());
    }
}
