<?php

declare(strict_types=1);

namespace AntonDPerera\PHPAttributesReader\Tests\Fixtures\ClassAttributes;

#[TestAttribute3]
#[TestAttribute4()]
#[TestAttribute5("")]
#[TestAttribute6(0)]
#[TestAttribute7("abc")]
class DummySimpleClass2WithClassAttributes
{
}
