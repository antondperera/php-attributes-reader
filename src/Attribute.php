<?php

declare(strict_types=1);

namespace AntonDPerera\PHPAttributesReader;

use ReflectionAttribute;

class Attribute
{
    private null | string $name = null;
    private null | string $class = null;
    private array $arguments = [];

    public function __construct(ReflectionAttribute $attribute)
    {

    }
}
