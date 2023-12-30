<?php

declare(strict_types=1);

namespace AntonDPerera\PHPAttributesReader\Tests;

use PHPUnit\Framework\TestCase;
use PHPUnit\Framework\Attributes\DataProvider;

use AntonDPerera\PHPAttributesReader\Argument;
use AntonDPerera\PHPAttributesReader\Tests\Fixtures\ClassAttributes\DummySimpleClass1WithClassAttributes;

class ArgumentTest extends TestCase
{
    public static function emptyArgumentsProvider(): array
    {
        return [
            [null, Argument::ARGUMENT_VALUE_TYPE_EMPTY],
            [0, Argument::ARGUMENT_VALUE_TYPE_EMPTY],
            ["0", Argument::ARGUMENT_VALUE_TYPE_EMPTY],
            [0.0, Argument::ARGUMENT_VALUE_TYPE_EMPTY],
            [0.0, Argument::ARGUMENT_VALUE_TYPE_EMPTY],
        ];
    }

    #[DataProvider('emptyArgumentsProvider')]
    public function testWhenArgumentValueIsEmpty(mixed $argument, int $expected): void
    {
        $argument = new Argument($argument);
        $this->assertSame($expected, $argument->getType());
    }

    public static function booleanArgumentsProvider(): array
    {
        return [
            [true, Argument::ARGUMENT_VALUE_TYPE_BOOLEAN],
            [false, Argument::ARGUMENT_VALUE_TYPE_BOOLEAN]
        ];
    }

    #[DataProvider('booleanArgumentsProvider')]
    public function testWhenArgumentValueIsBoolean(mixed $argument, int $expected): void
    {
        $argument = new Argument($argument);
        $this->assertSame($expected, $argument->getType());
    }

    public static function sequentialArrayArgumentsProvider(): array
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

    #[DataProvider('sequentialArrayArgumentsProvider')]
    public function testWhenArgumentValueIsSequentialArray(mixed $argument, int $expected): void
    {
        $argument = new Argument($argument);
        $this->assertSame($expected, $argument->getType());
    }

    public static function associativeArrayArgumentsProvider(): array
    {
        return [
            [
                [1 => "a"],
                Argument::ARGUMENT_VALUE_TYPE_ASSOCIATIVE_ARRAY
            ],
            [
                ["a" => 1],
                Argument::ARGUMENT_VALUE_TYPE_ASSOCIATIVE_ARRAY
            ],
            [
                [
                    "a" => 1,
                    "b" => "c",
                ],
                Argument::ARGUMENT_VALUE_TYPE_ASSOCIATIVE_ARRAY
            ],
            [
                [
                    "a" => 1,
                    "b" => []
                ],
                Argument::ARGUMENT_VALUE_TYPE_ASSOCIATIVE_ARRAY
            ],
            [
                [
                    "a" => 1,
                    "b" => ["c", "d"]
                ],
                Argument::ARGUMENT_VALUE_TYPE_ASSOCIATIVE_ARRAY
            ],
            [
                [
                    "a" => 1,
                    "b" => (object)["c", "d"]
                ],
                Argument::ARGUMENT_VALUE_TYPE_ASSOCIATIVE_ARRAY
            ],
        ];
    }

    #[DataProvider('associativeArrayArgumentsProvider')]
    public function testWhenArgumentValueIsAssociativeArray(mixed $argument, int $expected): void
    {
        $argument = new Argument($argument);
        $this->assertSame($expected, $argument->getType());
    }

    public static function objectArgumentsProvider(): array
    {
        return [
            [
                (object)["a" => 1],
                Argument::ARGUMENT_VALUE_TYPE_OBJECT
            ],
            [
                (object)[
                    "a" => 1,
                    "b" => "c",
                ],
                Argument::ARGUMENT_VALUE_TYPE_OBJECT
            ],
            [
                (object)[
                    "a" => 1,
                    "b" => ["c", "d"]
                ],
                Argument::ARGUMENT_VALUE_TYPE_OBJECT
            ],
            [
                (object)[
                    "a" => 1,
                    "b" => (object)["c", "d"]
                ],
                Argument::ARGUMENT_VALUE_TYPE_OBJECT
            ],
            [
                new DummySimpleClass1WithClassAttributes(),
                Argument::ARGUMENT_VALUE_TYPE_OBJECT
            ],
        ];
    }

    #[DataProvider('objectArgumentsProvider')]
    public function testWhenArgumentValueIsObject(mixed $argument, int $expected): void
    {
        $argument = new Argument($argument);
        $this->assertSame($expected, $argument->getType());
    }

    public static function SimpleValueTypesArgumentsProvider(): array
    {
        return [
            [0.23, Argument::ARGUMENT_VALUE_TYPE_FLOAT],
            [0.23754, Argument::ARGUMENT_VALUE_TYPE_FLOAT],
            [20, Argument::ARGUMENT_VALUE_TYPE_INT],
            [1000, Argument::ARGUMENT_VALUE_TYPE_INT],
            ["0.0", Argument::ARGUMENT_VALUE_TYPE_STRING],
            ["10.20", Argument::ARGUMENT_VALUE_TYPE_STRING],
            ["ABCD", Argument::ARGUMENT_VALUE_TYPE_STRING],
            ["abcd", Argument::ARGUMENT_VALUE_TYPE_STRING],
            ["!^&$%", Argument::ARGUMENT_VALUE_TYPE_STRING],
        ];
    }

    #[DataProvider('SimpleValueTypesArgumentsProvider')]
    public function testWhenArgumentValueIsASimpleDataType(mixed $argument, int $expected): void
    {
        $argument = new Argument($argument);
        $this->assertSame($expected, $argument->getType());
    }
}
