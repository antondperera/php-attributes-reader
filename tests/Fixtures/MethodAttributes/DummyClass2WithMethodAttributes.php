<?php

declare(strict_types=1);

namespace AntonDPerera\PHPAttributesReader\Tests\Fixtures\MethodAttributes;

define("DUMMY_ARGUMENT_OBJECT", (object)["property1"=>"property1 value"]);

class DummyClass2WithMethodAttributes
{
    #[TestAttribute3(DUMMY_ARGUMENT_OBJECT)]
    public function getDummyMethod3WithAttributes(): bool
    {
        return true;
    }
}
