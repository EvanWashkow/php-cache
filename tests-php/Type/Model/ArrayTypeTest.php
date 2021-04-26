<?php
declare(strict_types = 1);

namespace PHP\Tests\Type\Model;

use PHP\Type\Model\ArrayType;
use PHP\Type\Model\BooleanType;
use PHP\Type\Model\FloatType;
use PHP\Type\Model\IntegerType;
use PHP\Type\Model\Type;

/**
 * Tests the ArrayType class
 */
final class ArrayTypeTest extends TestDefinition\StaticTypeTestDefinition
{
    public function getIsOfTypeTestData(): array
    {
        return [
            'is(ArrayType)' => [$this->getOrCreateType(), true],
            'is(BooleanType)' => [new BooleanType(), false],
            'is(FloatType)' => [new FloatType(), false],
            'is(IntegerType)' => [new IntegerType(), false],
        ];
    }


    public function getIsValueOfTypeTestData(): array
    {
        return [
            'isValueOfType([])' => [[], true],
            'isValueOfType([1,2,3])' => [[1,2,3], true],
            'isValueOfType(1)' => [1, false],
            'isValueOfType(2.7)' => [2.7, false],
            'isValueOfType(false)' => [false, false],
        ];
    }


    protected function createType(): Type
    {
        return new ArrayType();
    }


    protected function getExpectedTypeName(): string
    {
        return 'array';
    }
}
