<?php

declare(strict_types=1);

namespace AntonDPerera\PHPAttributesReader\Traits;

use ReflectionClass;

use AntonDPerera\PHPAttributesReader\Exceptions\MethodNotFoundException;
use AntonDPerera\PHPAttributesReader\Exceptions\MethodAttributeNotFoundException;
use AntonDPerera\PHPAttributesReader\Attribute;

trait MethodAttributesSupport
{
    private array $method_attributes = [];

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

    public function getMethodAttributes(?string $method_name = null): null | array | MethodNotFoundException
    {
        if (is_null($method_name)) {
            return $this->method_attributes;
        }

        if (!array_key_exists($method_name, $this->method_attributes)) {
            throw new MethodNotFoundException("Method {$method_name} not found in the Method Attributes list.");
        }
        return $this->method_attributes[$method_name];
    }

    public function getMethodAttribute(string $method_name, string $attribute_name): null | Attribute | MethodAttributeNotFoundException
    {
        $method_attributes_list = $this->getMethodAttributes($method_name);
        if (!array_key_exists($attribute_name, $method_attributes_list)) {
            throw new MethodAttributeNotFoundException("Attribute {$attribute_name} not found in the Method Attributes list for method {$method_name}.");
        }
        return $method_attributes_list[$attribute_name];
    }
}
