<?php
declare(strict_types=1);

namespace PHP\Tests\Type\Model\TestDefinition;

use PHP\Type\Model\Type;

/**
 * Defines tests for a Type implementation
 */
abstract class TypeTestDefinition extends \PHPUnit\Framework\TestCase
{
    /**
     * Return isValueOfType() test data
     *
     * @return array<TypeIs[]>
     */
    abstract public function getIsTestData(): array;

    /**
     * Return isValueOfType() test data
     */
    abstract public function getIsValueOfTypeTestData(): array;

    /**
     * Retrieve test data for getNames() test
     */
    abstract public function getNamesTestData(): array;


    /**
     * Test getName() results
     *
     * @dataProvider getNamesTestData
     *
     * @param Type $type
     * @param string $expectedName
     */
    final public function testGetName(Type $type, string $expectedName): void
    {
        $this->assertEquals(
            $expectedName,
            $type->getName(),
            "{$this->getClassName($type)}->getName() did not return the expected type name."
        );
    }


    /**
     * Tests the Type->is() function
     *
     * @dataProvider getIsTestData
     *
     * @param TypeIs $typeIsExpression
     */
    final public function testIs(Type $type, $isFuncArg, bool $expectedResult): void
    {
        /**
         * Test Type->is(Type)
         */
        if ($isFuncArg instanceof Type)
        {
            $this->assertEquals(
                $expectedResult,
                $type->is($isFuncArg),
                "{$this->getClassName($type)}->is(Type) returned the wrong value."
            );

            // Call the test again, this time to test Type->is(string $typeName)
            $this->testIs($type, $isFuncArg->getName(), $expectedResult);
        }

        /**
         * Test Type->is(string)
         */
        elseif (is_string($isFuncArg))
        {
            $this->assertEquals(
                $expectedResult,
                $type->is($isFuncArg),
                "{$this->getClassName($type)}->is(string) returned the wrong value."
            );
        }

        /**
         * Somebody wrote the test wrong
         */
        else
        {
            throw new \InvalidArgumentException('$isFuncArg expected to be a Type or a string.');
        }
    }


    /**
     * Tests the isValueOfType() function
     *
     * @dataProvider getIsValueOfTypeTestData
     *
     * @param Type $type The Type
     * @param mixed $value The value
     * @param bool $expected The expected result
     */
    final public function testIsValueOfType(Type $type, $value, bool $expected): void
    {
        $this->assertEquals(
            $expected,
            $type->isValueOfType($value),
            "{$this->getClassName($type)}->isValueOfType() returned the wrong result."
        );
    }


    /**
     * Retrieves the class name for the given Type instance
     *
     * @param Type $type The Type
     */
    private function getClassName(Type $type): string
    {
        return get_class($type);
    }
}
