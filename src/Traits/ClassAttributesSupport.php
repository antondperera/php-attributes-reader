<?php

declare(strict_types=1);

namespace AntonDPerera\PHPAttributesReader\Traits;

use ReflectionClass;

use AntonDPerera\PHPAttributesReader\Exceptions\ClassAttributeNotFoundException;
use AntonDPerera\PHPAttributesReader\Attribute;

trait ClassAttributesSupport
{
    private string $class = "";
    private array $class_attributes = [];

    private function processClassAttributes(): void
    {
        $reflection = new ReflectionClass($this->class);
        $class_attributes = $reflection->getAttributes();
        foreach ($class_attributes as $reflection_attribute) {
            $attribute = new Attribute($reflection_attribute);
            $this->class_attributes[$attribute->getName()] = $attribute;
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

    public function getClassAttribute(string $attribute_name): Attribute | ClassAttributeNotFoundException
    {
        if (!array_key_exists($attribute_name, $this->class_attributes)) {
            throw new ClassAttributeNotFoundException("Attribute {$attribute_name} not found in the Class Attributes list.");
        }
        return $this->class_attributes[$attribute_name];
    }
}
