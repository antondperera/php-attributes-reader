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

    public function processMethodAttributes(): void
    {
        $reflection = new ReflectionClass($this->class);
        $reflection_methods = $reflection->getMethods();
        foreach ($reflection_methods as $reflection_method) {
            $method_attributes = $reflection_method->getAttributes();
            foreach ($method_attributes as $reflection_attribute) {
                $attribute = new Attribute($reflection_attribute);
                $this->method_attributes[$reflection_method->getName()][$attribute->getName()] = $attribute;
            }
        }
    }

    public function getAllMethodAttributes(): array
    {
        return $this->method_attributes;
    }

    public function getMethodAttributesByMethodName(string $method_name): ?array
    {
        return $this->method_attributes[$method_name] ?? null;
    }

    public function getMethodAttributeByAttributeName(string $method_name, string $attribute_name): Attribute
    {
        return $this->method_attributes[$method_name][$attribute_name] ?? null;
    }
}
