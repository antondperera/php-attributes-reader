<?php

declare(strict_types=1);

namespace AntonDPerera\PHPAttributesReader;

use AntonDPerera\PHPAttributesReader\Exceptions\InvalidClassException;
use AntonDPerera\PHPAttributesReader\Exceptions\ClassNotFoundException;

class Reader
{
    public function __construct(?string $class = null)
    {
        if (empty($class)) {
            throw new InvalidClassException("Invalid Class {$class}.");
        }
        if (empty($class) || !class_exists($class)) {
            throw new ClassNotFoundException("Class {$class} not found.");
        }
    }
}
