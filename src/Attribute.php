<?php

declare(strict_types=1);

namespace AntonDPerera\PHPAttributesReader;

use ReflectionAttribute;

use AntonDPerera\PHPAttributesReader\Interfaces\AttributeInterface;

class Attribute implements AttributeInterface
{
    private null | string $class = null;
    private null | string $name = null;
    private array $arguments = [];

    public function __construct(ReflectionAttribute $attribute)
    {
        $this->class = $attribute->getName();
        $this->name = $this->getAttributeName($attribute->getName());
        $this->arguments = $attribute->getArguments();
    }

    private function getAttributeName($attribute_class) {
        $parts = explode('\\', $attribute_class);
        return end($parts);
    }

    public function getClass(): string
    {
        return $this->class;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getArguments(): array
    {
        return $this->arguments;
    }
}
