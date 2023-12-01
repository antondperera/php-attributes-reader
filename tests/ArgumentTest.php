<?php

declare(strict_types=1);

namespace AntonDPerera\PHPAttributesReader\Tests;

use PHPUnit\Framework\TestCase;

use AntonDPerera\PHPAttributesReader\Argument;

class ArgumentTest extends TestCase
{
    public static function attributeArgumentProvider(): array
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
     * @dataProvider attributeArgumentProvider
     */
    public function testWhenArgumentValueIsEmpty(mixed $argument, int $expected): void
    {
        $argument = new Argument($argument);
        $this->assertSame($expected,$argument->getType());

    }

    
}
