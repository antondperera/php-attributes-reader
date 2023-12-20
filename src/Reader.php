<?php

declare(strict_types=1);

namespace AntonDPerera\PHPAttributesReader;

use ReflectionClass;

use AntonDPerera\PHPAttributesReader\Exceptions\InvalidClassException;
use AntonDPerera\PHPAttributesReader\Exceptions\ClassNotFoundException;

class Reader
{
    private string $class = "";
    private array $class_attributes = [];

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
    }

    public function processClassAttributes(): void
    {
        $reflection = new ReflectionClass($this->class);
        $class_attributes = $reflection->getAttributes();
        foreach ($class_attributes as $attribute) {
            $this->class_attributes[] = new Attribute($attribute);
        }
    }

    public function getClassAttributes(): array
    {
        return $this->class_attributes;
    }

    public function hasClassAttributes(): bool
    {
        return !empty($this->class_attributes);
    }
}
