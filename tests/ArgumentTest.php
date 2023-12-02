<?php

declare(strict_types=1);

namespace AntonDPerera\PHPAttributesReader\Tests;

use PHPUnit\Framework\TestCase;

use AntonDPerera\PHPAttributesReader\Argument;

class ArgumentTest extends TestCase
{
    public static function emptyArgumentProvider(): array
    {
        return [
            [null, Argument::ARGUMENT_VALUE_TYPE_EMPTY],
            [0, Argument::ARGUMENT_VALUE_TYPE_EMPTY],
            ["0", Argument::ARGUMENT_VALUE_TYPE_EMPTY],
            [0.0, Argument::ARGUMENT_VALUE_TYPE_EMPTY],
            [0.0, Argument::ARGUMENT_VALUE_TYPE_EMPTY],
        ];
    }

    /**
     * @dataProvider emptyArgumentProvider
     */
    public function testWhenArgumentValueIsEmpty(mixed $argument, int $expected): void
    {
        $argument = new Argument($argument);
        $this->assertSame($expected, $argument->getType());
    }

    public static function booleanArgumentProvider(): array
    {
        return [
            [true, Argument::ARGUMENT_VALUE_TYPE_BOOLEAN],
            [false, Argument::ARGUMENT_VALUE_TYPE_BOOLEAN]
        ];
    }

    /**
     * @dataProvider booleanArgumentProvider
     */
    public function testWhenArgumentValueIsBoolean(mixed $argument, int $expected): void
    {
        $argument = new Argument($argument);
        $this->assertSame($expected, $argument->getType());
    }

    public static function sequentialArrayArgumentProvider(): array
    {
        return [
            [
                ["a"],
                Argument::ARGUMENT_VALUE_TYPE_SEQUENTIAL_ARRAY
            ],
            [
                ["a", "b"],
                Argument::ARGUMENT_VALUE_TYPE_SEQUENTIAL_ARRAY
            ],
            [
                [0, 1],
                Argument::ARGUMENT_VALUE_TYPE_SEQUENTIAL_ARRAY
            ],
            [
                [0 => "a", "b"],
                Argument::ARGUMENT_VALUE_TYPE_SEQUENTIAL_ARRAY
            ],
        ];
    }

    /**
     * @dataProvider sequentialArrayArgumentProvider
     */
    public function testWhenArgumentValueIsSequentialArray(mixed $argument, int $expected): void
    {
        $argument = new Argument($argument);
        $this->assertSame($expected, $argument->getType());
    }
}
