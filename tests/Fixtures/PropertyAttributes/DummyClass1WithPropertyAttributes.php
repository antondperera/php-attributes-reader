<?php

declare(strict_types=1);

namespace AntonDPerera\PHPAttributesReader\Tests\Fixtures\PropertyAttributes;

class DummyClass1WithPropertyAttributes
{
    #[TestAttribute]
    #[TestAttribute2("abc")]
    public $property2_with_attributes = null;
}
