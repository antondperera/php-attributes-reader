<?php

declare(strict_types=1);

namespace AntonDPerera\PHPAttributesReader;

class Argument
{
    public const ARGUMENT_VALUE_TYPE_EMPTY = 0;
    public const ARGUMENT_VALUE_TYPE_BOOLEAN = 1;
    public const ARGUMENT_VALUE_TYPE_BASIC = 2;
    public const ARGUMENT_VALUE_TYPE_INDEXED_ARRAY = 3;
    public const ARGUMENT_VALUE_TYPE_ASSOCIATIVE_ARRAY = 4;
    public const ARGUMENT_VALUE_TYPE_OBJECT = 5;

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
