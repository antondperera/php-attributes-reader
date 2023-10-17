<?php

declare(strict_types=1);

namespace AntonDPerera\PHPAttributesReader\Tests;

use PHPUnit\Framework\TestCase;
use AntonDPerera\PHPAttributesReader\Attribute;
use TypeError;

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
        $reader = new Attribute($class);
    }
}
