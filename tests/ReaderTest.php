<?php

declare(strict_types=1);

namespace AntonDPerera\PHPAttributesReader\Tests;

use PHPUnit\Framework\TestCase;
use AntonDPerera\PHPAttributesReader\Reader;
use AntonDPerera\PHPAttributesReader\Exceptions\InvalidClassException;
use AntonDPerera\PHPAttributesReader\Exceptions\ClassNotFoundException;

class ReaderTest extends TestCase
{
    public static function invalidClassNameProvider(): array
    {
        return [
            [''],
            [""],
            ["0"],
            [null]
        ];
    }

    /**
     * @dataProvider invalidClassNameProvider
     */
    public function testExceptionWhenInvalidClassGiven(?string $class = null): void
    {
        $this->expectException(InvalidClassException::class);
        $reader = new Reader($class);
    }

    public static function nonExistingClassNameProvider(): array
    {
        return [
            ["notExistingClass"],
            ["SomeDummyNotExistingClass"],
            ["class"],
            [notExistingClass::class],
        ];
    }

    /**
     * @dataProvider nonExistingClassNameProvider
     */
    public function testExceptionWhenNonExistingClassGiven(?string $class = null): void
    {
        $this->expectException(ClassNotFoundException::class);
        $reader = new Reader($class);
    }
}
