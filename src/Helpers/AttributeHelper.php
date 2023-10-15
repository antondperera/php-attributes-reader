<?php

declare(strict_types=1);

namespace AntonDPerera\PHPAttributesReader\Helpers;

use ReflectionAttribute;

class AttributeHelper
{
    public static function isAValidAttribute(mixed $attribute): bool
    {
        if(empty($attribute)) { return false; }

        return $attribute instanceof ReflectionAttribute;
    }
}