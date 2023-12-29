<?php

declare(strict_types=1);

namespace AntonDPerera\PHPAttributesReader;

use AntonDPerera\PHPAttributesReader\Exceptions\InvalidClassException;
use AntonDPerera\PHPAttributesReader\Exceptions\ClassNotFoundException;
use AntonDPerera\PHPAttributesReader\Traits\ClassAttributesSupport;
use AntonDPerera\PHPAttributesReader\Traits\MethodAttributesSupport;
use AntonDPerera\PHPAttributesReader\Traits\PropertyAttributesSupport;

class AttributesReader
{
    use ClassAttributesSupport;
    use MethodAttributesSupport;
    use PropertyAttributesSupport;

    private array $method_attributes = [];

    public function __construct(?string $class = null)
    {
        if (empty($class)) {
            throw new InvalidClassException("Invalid Class {$class}.");
        }
        if (!class_exists($class)) {
            throw new ClassNotFoundException("Class {$class} not found.");
        }

        $this->class = $class;
        $this->processClassAttributes();
        $this->processMethodAttributes();
        $this->processPropertyAttributes();
    }
}
