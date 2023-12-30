<?php

declare(strict_types=1);

namespace AntonDPerera\PHPAttributesReader\Tests\Fixtures\MethodAttributes;

class DummyClass1WithMethodAttributes
{
    #[TestAttribute]
    #[TestAttribute2("abc")]
    public function getDummyMethod2WithAttributes(): bool
    {
        return true;
    }
}
