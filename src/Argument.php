<?php

declare(strict_types=1);

namespace AntonDPerera\PHPAttributesReader;

class Argument
{
    public const ARGUMENT_VALUE_TYPE_EMPTY = 0;
    public const ARGUMENT_VALUE_TYPE_BOOLEAN = 1;
    public const ARGUMENT_VALUE_TYPE_STRING = 2;
    public const ARGUMENT_VALUE_TYPE_INT = 3;
    public const ARGUMENT_VALUE_TYPE_FLOAT = 4;
    public const ARGUMENT_VALUE_TYPE_SEQUENTIAL_ARRAY = 5;
    public const ARGUMENT_VALUE_TYPE_ASSOCIATIVE_ARRAY = 6;
    public const ARGUMENT_VALUE_TYPE_OBJECT = 7;

    public const ARGUMENT_VALUE_TYPE_OTHER = 50;


    private mixed $value = null;
    private mixed $type = null;

    public function __construct(mixed $argument)
    {
        $this->type = $this->determineType($argument);
        $this->value = $argument;
    }

    private function determineType(mixed $argument): int
    {
        if(is_bool($argument)) {
            return self::ARGUMENT_VALUE_TYPE_BOOLEAN;
        }

        if(empty($argument)) {
            return self::ARGUMENT_VALUE_TYPE_EMPTY;
        }

        if(is_array($argument)) {
            if(array_is_list($argument)) {
                return self::ARGUMENT_VALUE_TYPE_SEQUENTIAL_ARRAY;
            }
            return self::ARGUMENT_VALUE_TYPE_ASSOCIATIVE_ARRAY;
        }

        if(is_object($argument)) {
            return self::ARGUMENT_VALUE_TYPE_OBJECT;
        }

        if(is_float($argument)) {
            return self::ARGUMENT_VALUE_TYPE_FLOAT;
        }

        if(is_int($argument)) {
            return self::ARGUMENT_VALUE_TYPE_INT;
        }

        if(is_string($argument)) {
            return self::ARGUMENT_VALUE_TYPE_STRING;
        }

        return self::ARGUMENT_VALUE_TYPE_OTHER;
    }

    public function getValue(): mixed
    {
        return $this->value;
    }

    public function getType(): int
    {
        return $this->type;
    }
}
