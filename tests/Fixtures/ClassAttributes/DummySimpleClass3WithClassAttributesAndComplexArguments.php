<?php

declare(strict_types=1);

namespace AntonDPerera\PHPAttributesReader\Tests\Fixtures\ClassAttributes;

define("DUMMY_ARGUMENT_OBJECT", (object)["property1"=>"property1 value"]);

#[TestAttribute10(DUMMY_ARGUMENT_OBJECT)]
#[TestAttribute11(["key1"=>"key1 value"])]
#[TestAttribute12(10.13)]
#[TestAttribute13(123)]
#[TestAttribute14()]
#[TestAttribute15(["value1", "value2"])]
class DummySimpleClass3WithClassAttributesAndComplexArguments
{
}
