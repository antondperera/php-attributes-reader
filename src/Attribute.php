<?php

declare(strict_types=1);

namespace AntonDPerera\PHPAttributesReader;

use ReflectionAttribute;

use AntonDPerera\PHPAttributesReader\Interfaces\AttributeInterface;

class Attribute implements AttributeInterface
{
    private null | string $class = null;
    private null | string $name = null;
    private array $parameters = [];

    public function __construct(ReflectionAttribute $attribute)
    {
        $this->class = $attribute->getName();
        $this->name = $this->getClassBaseName($attribute->getName());
        $this->parameters = $attribute->getArguments();
    }

    private function getClassBaseName($fullNamespace) {
        $parts = explode('\\', $fullNamespace);
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
        return $this->parameters;
    }
}
