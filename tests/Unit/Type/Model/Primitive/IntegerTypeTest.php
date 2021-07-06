<?php
declare(strict_types = 1);

namespace EvanWashkow\PhpLibraries\Tests\Unit\Type\Model\Primitive;

use EvanWashkow\PhpLibraries\Tests\Unit\Type\Model\TestDefinition\TypeTestDefinition;
use EvanWashkow\PhpLibraries\Type\Model\Primitive\ArrayType;
use EvanWashkow\PhpLibraries\Type\Model\Primitive\BooleanType;
use EvanWashkow\PhpLibraries\Type\Model\Primitive\FloatType;
use EvanWashkow\PhpLibraries\Type\Model\Primitive\IntegerType;

/**
 * Tests the IntegerType class
 */
final class IntegerTypeTest extends TypeTestDefinition
{
    public function getIsTestData(): array
    {
        $type = new IntegerType();
        return [
            'IntegerType' => [$type, $type, true],
            'ArrayType' => [$type, new ArrayType(), false],
            'BooleanType' => [$type, new BooleanType(), false],
            'FloatType' => [$type, new FloatType(), false],
        ];
    }


    public function getIsUnknownTypeNameTestData(): array
    {
        return [
            'IntegerType' => [new IntegerType()],
        ];
    }


    public function getIsValueOfTypeTestData(): array
    {
        $type = new IntegerType();
        return [
            '1' => [$type, 1, true],
            '[]' => [$type, [], false],
            '1.0' => [$type, 1.0, false],
            '2.7' => [$type, 2.7, false],
            'false' => [$type, false, false],
        ];
    }


    public function getNameTestData(): array
    {
        return [
            'IntegerType' => [new IntegerType(), IntegerType::INTEGER_NAME],
        ];
    }
}