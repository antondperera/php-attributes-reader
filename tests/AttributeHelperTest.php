<?php

declare(strict_types=1);

namespace AntonDPerera\PHPAttributesReader\Tests;

use PHPUnit\Framework\TestCase;
use AntonDPerera\PHPAttributesReader\Helpers\AttributeHelper;
use stdClass;
use ReflectionClass;
use AntonDPerera\PHPAttributesReader\Tests\Fixtures\DummySimpleClassWithClassAttributes;

class AttributeHelperTest extends TestCase
{
    public static function invalidAttributeProvider(): array
    {
        return [
            ["", false],
            [2, false],
            [null, false],
            [new stdClass(), false]
        ];
    }

    /**
     * @dataProvider invalidAttributeProvider
     */
    public function testIsAValidAttributeWhenInvalidValueGiven(mixed $attribute, bool $expected): void
    {
        $actual = AttributeHelper::isAValidAttribute($attribute);
        $this->assertSame($expected, $actual);
    }

    public function testIsAValidAttributeWhenValidValueGiven(): void
    {
        $reflection = new ReflectionClass(DummySimpleClassWithClassAttributes::class);
        $class_attributes = $reflection->getAttributes();
        $actual = AttributeHelper::isAValidAttribute($class_attributes[0]);
        $this->assertTrue($actual);
    }
}
