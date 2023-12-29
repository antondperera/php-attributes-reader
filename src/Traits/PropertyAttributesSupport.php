<?php

declare(strict_types=1);

namespace AntonDPerera\PHPAttributesReader\Traits;

use ReflectionClass;

use AntonDPerera\PHPAttributesReader\Exceptions\PropertyNotFoundException;
use AntonDPerera\PHPAttributesReader\Exceptions\PropertyAttributeNotFoundException;
use AntonDPerera\PHPAttributesReader\Attribute;

trait PropertyAttributesSupport
{
    private array $property_attributes = [];

    private function processPropertyAttributes(): void
    {
        $reflection = new ReflectionClass($this->class);
        $reflection_propertys = $reflection->getProperties();
        foreach ($reflection_propertys as $reflection_property) {
            $property_attributes = $reflection_property->getAttributes();
            foreach ($property_attributes as $reflection_attribute) {
                $attribute = new Attribute($reflection_attribute);
                $this->property_attributes[$reflection_property->getName()][$attribute->getName()] = $attribute;
            }
        }
    }

    public function getPropertyAttributes(?string $property_name = null): null | array | PropertyNotFoundException
    {
        if (is_null($property_name)) {
            return $this->property_attributes;
        }

        if ($this->isPropertyExistsInPropertyAttributesList($property_name)) {
            return $this->property_attributes[$property_name];
        }
    }

    private function isPropertyExistsInPropertyAttributesList(string $property_name): bool | PropertyNotFoundException
    {
        if (!array_key_exists($property_name, $this->property_attributes)) {
            throw new PropertyNotFoundException("Property {$property_name} not found in the Property Attributes list.");
        }
        return true;
    }

    public function getPropertyAttribute(string $property_name, string $attribute_name): null | Attribute | PropertyAttributeNotFoundException
    {
        if ($this->isPropertyExistsInPropertyAttributesList($property_name)) {
            $property_attributes_list = $this->getPropertyAttributes($property_name);
        }

        if (!array_key_exists($attribute_name, $property_attributes_list)) {
            throw new PropertyAttributeNotFoundException("Attribute {$attribute_name} not found in the Property Attributes list for property {$property_name}.");
        }
        return $property_attributes_list[$attribute_name];
    }
}
