<?php
declare(strict_types=1);

namespace PHP\Tests\Type\Model;

use PHP\Type\Model\ArrayType;
use PHP\Type\Model\BooleanType;
use PHP\Type\Model\ClassType;
use PHP\Type\Model\FloatType;
use PHP\Type\Model\InterfaceType;

/**
 * Tests the InterfaceType class
 */
final class InterfaceTypeTest extends TestDefinition\TypeTestDefinition
{

    /**
     * @inheritDoc
     */
    public function getIsTestData(): array
    {
        $interfaceA = new InterfaceType(new \ReflectionClass(InterfaceA::class));
        $interfaceB = new InterfaceType(new \ReflectionClass(InterfaceB::class));
        $interfaceC = new InterfaceType(new \ReflectionClass(InterfaceC::class));
        $interfaceX = new InterfaceType(new \ReflectionClass(InterfaceX::class));

        return [

            // Other Type instances
            'InterfaceA->is(ArrayType)' => [$interfaceA, new ArrayType(), false],
            'InterfaceB->is(ArrayType)' => [$interfaceB, new ArrayType(), false],
            'InterfaceA->is(BooleanType)' => [$interfaceA, new BooleanType(), false],
            'InterfaceB->is(BooleanType)' => [$interfaceB, new BooleanType(), false],
            'InterfaceA->is(FloatType)' => [$interfaceA, new FloatType(), false],
            'InterfaceB->is(FloatType)' => [$interfaceB, new FloatType(), false],

            // InterfaceType instances
            'InterfaceA->is(InterfaceB)' =>[$interfaceA, $interfaceB, false],
            'InterfaceA->is(InterfaceC)' => [$interfaceA, $interfaceC, false],
            'InterfaceA->is(InterfaceX)' => [$interfaceA, $interfaceX, false],
            'InterfaceA->is(InterfaceA)' => [$interfaceA, $interfaceA, true],
            'InterfaceB->is(InterfaceA)' => [$interfaceB, $interfaceA, true],
            'InterfaceC->is(InterfaceA)' => [$interfaceC, $interfaceA, true],
            'InterfaceX->is(InterfaceX)' => [$interfaceX, $interfaceX, true],

            // ClassType instances
            'InterfaceA->is(ClassType(ClassA))' => [
                $interfaceA,
                new ClassType(new \ReflectionClass(ClassA::class)),
                false
            ],
            'InterfaceB->is(ClassType(ClassB))' => [
                $interfaceB,
                new ClassType(new \ReflectionClass(ClassB::class)),
                false
            ],
            'InterfaceC->is(ClassType(ClassC))' => [
                $interfaceC,
                new ClassType(new \ReflectionClass(ClassC::class)),
                false
            ],
            'InterfaceX->is(ClassType(ClassX))' => [
                $interfaceX,
                new ClassType(new \ReflectionClass(ClassX::class)),
                false
            ],
        ];
    }


    /**
     * @inheritDoc
     */
    public function getIsUnknownTypeNameTestData(): array
    {
        $interfaceA = new InterfaceType(new \ReflectionClass(InterfaceA::class));
        return [
            'InterfaceType(InterfaceA)' => [$interfaceA],
        ];
    }


    /**
     * @inheritDoc
     */
    public function getIsValueOfTypeTestData(): array
    {
        $interfaceA = new InterfaceType(new \ReflectionClass(InterfaceA::class));
        $interfaceB = new InterfaceType(new \ReflectionClass(InterfaceB::class));
        $interfaceC = new InterfaceType(new \ReflectionClass(InterfaceC::class));
        $interfaceX = new InterfaceType(new \ReflectionClass(InterfaceX::class));

        $objectA = new ClassA();
        $objectB = new ClassB();
        $objectC = new ClassC();
        $objectX = new ClassX();

        return [

            // Primitive types
            'InterfaceA->isValueOfType([])' => [$interfaceA, [], false],
            'InterfaceA->isValueOfType(1)' => [$interfaceA, 1, false],
            'InterfaceA->isValueOfType(false)' => [$interfaceA, false, false],
            'InterfaceA->isValueOfType(6.7)' => [$interfaceA, 6.7, false],

            // Object instances
            'InterfaceA->isValueOfType(ObjectA)' => [$interfaceA, $objectA, true],
            'InterfaceA->isValueOfType(ObjectX)' => [$interfaceA, $objectX, false],
            'InterfaceA->isValueOfType(ObjectB)' => [$interfaceA, $objectB, true],
            'InterfaceA->isValueOfType(ObjectC)' => [$interfaceA, $objectC, true],
            'InterfaceB->isValueOfType(ObjectA)' => [$interfaceB, $objectA, false],
            'InterfaceB->isValueOfType(ObjectB)' => [$interfaceB, $objectB, true],
            'InterfaceB->isValueOfType(ObjectC)' => [$interfaceB, $objectC, false],
            'InterfaceC->isValueOfType(ObjectA)' => [$interfaceC, $objectA, false],
            'InterfaceC->isValueOfType(ObjectB)' => [$interfaceC, $objectB, false],
            'InterfaceC->isValueOfType(ObjectC)' => [$interfaceC, $objectC, true],
            'InterfaceX->isValueOfType(ObjectX)' => [$interfaceX, $objectX, true],
            'InterfaceX->isValueOfType(ObjectA)' => [$interfaceX, $objectA, false],
        ];
    }


    /**
     * @inheritDoc
     */
    public function getNameTestData(): array
    {
        return [
            InterfaceA::class => [
                new InterfaceType(new \ReflectionClass(InterfaceA::class)),
                InterfaceA::class
            ],
            InterfaceB::class => [
                new InterfaceType(new \ReflectionClass(InterfaceB::class)),
                InterfaceB::class
            ],
            InterfaceC::class => [
                new InterfaceType(new \ReflectionClass(InterfaceC::class)),
                InterfaceC::class
            ],
            InterfaceX::class => [
                new InterfaceType(new \ReflectionClass(InterfaceX::class)),
                InterfaceX::class
            ],
        ];
    }
}


interface InterfaceA {}
interface InterfaceB extends InterfaceA {}
interface InterfaceC extends InterfaceA {}
interface InterfaceX {}

class ClassA implements InterfaceA {}
class ClassB Implements InterfaceB {}
class ClassC implements InterfaceC {}
class ClassX implements InterfaceX {}