<?php

declare(strict_types=1);

namespace AntonDPerera\PHPAttributesReader\Tests\Fixtures;

#[TestAttribute3]
#[TestAttribute3()]
#[TestAttribute4("")]
#[TestAttribute3(0)]
#[TestAttribute3("abc")]
class DummySimpleClass2WithClassAttributes
{
}
