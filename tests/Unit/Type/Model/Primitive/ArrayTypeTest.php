<?php
declare(strict_types=1);

namespace EvanWashkow\PhpLibraries\Tests\Unit\Type\Model\Primitive;

use EvanWashkow\PhpLibraries\Tests\Unit\Type\Model\TestDefinition\TypeTestDefinition;
use EvanWashkow\PhpLibraries\Type\Model\Primitive\ArrayType;
use EvanWashkow\PhpLibraries\Type\Model\Primitive\BooleanType;
use EvanWashkow\PhpLibraries\Type\Model\Primitive\FloatType;
use EvanWashkow\PhpLibraries\Type\Model\Primitive\IntegerType;

final class ArrayTypeTest extends TypeTestDefinition
{
    public function getIsTestData(): array
    {
        $type = new ArrayType();
        $childType = new class extends ArrayType {};
        return [
            'ArrayType' => [$type, $type, true],
            'ChildType->is(ArrayType)' => [$childType, $type, true],
            'ArrayType->is(ChildType)' => [$type, $childType, true],
            'BooleanType' => [$type, new BooleanType(), false],
            'FloatType' => [$type, new FloatType(), false],
            'IntegerType' => [$type, new IntegerType(), false],
        ];
    }


    public function getIsUnknownTypeNameTestData(): array
    {
        return [
            'ArrayType' => [new ArrayType()]
        ];
    }


    public function getIsValueOfTypeTestData(): array
    {
        $type = new ArrayType();
        return [
            '[]' => [$type, [], true],
            '[1,2,3]' => [$type, [1,2,3], true],
            '1' => [$type, 1, false],
            '2.7' => [$type, 2.7, false],
            'false' => [$type, false, false],
        ];
    }


    public function getNameTestData(): array
    {
        return [
            'ArrayType' => [new ArrayType(), ArrayType::NAME],
        ];
    }
}