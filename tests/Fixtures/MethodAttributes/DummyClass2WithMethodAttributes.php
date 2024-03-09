<?php

declare(strict_types=1);

namespace AntonDPerera\PHPAttributesReader\Tests\Fixtures\MethodAttributes;

class DummyClass2WithMethodAttributes
{
    #[TestAttribute3('dummyValue')]
    public function getDummyMethod3WithAttributes(): bool
    {
        return true;
    }
}
