<?php

declare(strict_types=1);

namespace AntonDPerera\PHPAttributesReader\Tests\Fixtures\PropertyAttributes;

class DummyClass2WithPropertyAttributes
{
    #[TestAttribute3('dummyValue')]
    public $property3_with_attributes = null;
}
