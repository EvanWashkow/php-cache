<?php
namespace PHP\Tests\Types\Models;

use PHP\ObjectClass;
use PHP\Tests\Interfaces\IEquatableTests;
use PHP\Types\Models\Type;
use PHP\Types\TypeLookupSingleton;
use PHP\Types\TypeNames;
use PHPUnit\Framework\TestCase;

/**
 * Tests the base Type functionality
 */
class TypeTest extends TestCase
{




    /*******************************************************************************************************************
    *                                                  Type inheritance
    *******************************************************************************************************************/


    /**
     * Ensure Type is an ObjectClass
     */
    public function testTypeIsObjectClass(): void
    {
        $this->assertInstanceOf(
            ObjectClass::class,
            TypeLookupSingleton::getInstance()->getByName( TypeNames::INT ),
            'Type is not an ObjectClass'
        );
    }




    /*******************************************************************************************************************
     *                                                  IEquatable Tests
     ******************************************************************************************************************/


    /**
     * Retrieves a single instance of IEquatableTests
     *
     * @return IEquatableTests
     */
    private function getIEquatableTestsInstance(): IEquatableTests
    {
        static $iequatableTests = null;
        if (null ===$iequatableTests)
        {
            $iequatableTests = new IEquatableTests($this);
        }
        return $iequatableTests;
    }


    /**
     * Test the Type->equals() method
     *
     * @dataProvider getEqualsData
     *
     * @param Type $type
     * @param $typeOrValue
     * @param bool $expected
     */
    public function testEquals( Type $type, $typeOrValue, bool $expected )
    {
        $this->getIEquatableTestsInstance()->testEquals($type, $typeOrValue, $expected);
    }


    public function getEqualsData(): array
    {
        $typeLookup = TypeLookupSingleton::getInstance();

        return [

            // Integer
            'getByValue(1)->equals( getByName("int") )' => [
                $typeLookup->getByValue( 1 ),
                $typeLookup->getByName( 'int' ),
                true
            ],
            'getByValue(1)->equals( 2 )' => [
                $typeLookup->getByValue( 1 ),
                2,
                true
            ],
            'getByValue(1)->equals( "1" )' => [
                $typeLookup->getByValue( 1 ),
                "1",
                false
            ],
            'getByValue(1)->equals( getByName("bool") )' => [
                $typeLookup->getByValue( 1 ),
                $typeLookup->getByName( 'bool' ),
                false
            ],
            'getByValue(1)->equals( true )' => [
                $typeLookup->getByValue( 1 ),
                true,
                false
            ],

            // Strings
            'getByValue( "1" )->equals( getByName("string") )' => [
                $typeLookup->getByValue( '1' ),
                $typeLookup->getByName( 'string' ),
                true
            ],
            'getByValue( "1" )->equals( "2" )' => [
                $typeLookup->getByValue( '1' ),
                "2",
                true
            ],
            'getByValue( "1" )->equals( 1 )' => [
                $typeLookup->getByValue( '1' ),
                1,
                false
            ],
            'getByValue( "1" )->equals( getByName( "bool" ) )' => [
                $typeLookup->getByValue( '1' ),
                $typeLookup->getByName( 'bool' ),
                false
            ],
            'getByValue( "1" )->equals( true )' => [
                $typeLookup->getByValue( '1' ),
                true,
                false
            ],

            // Booleans
            'getByValue( true )->equals( getByName("bool") )' => [
                $typeLookup->getByValue( true ),
                $typeLookup->getByName( 'bool' ),
                true
            ],
            'getByValue( true )->equals( false )' => [
                $typeLookup->getByValue( true ),
                false,
                true
            ],
            'getByValue( true )->equals( 1 )' => [
                $typeLookup->getByValue( true ),
                1,
                false
            ]
        ];
    }




    /*******************************************************************************************************************
    *                                                Type->__construct()
    *******************************************************************************************************************/


    /**
     * Ensure Type->__construct throws an exception on an empty name
     * 
     * @expectedException \DomainException
     **/
    public function testConstructThrowsExceptionOnEmptyName()
    {
        new Type( '' );
    }
    
    
    
    
    /*******************************************************************************************************************
    *                                             Type->getName() and getNames()
    *
    * This was already tested when testing type lookup in TypesTest. Nothing to
    * do here.
    *******************************************************************************************************************/
    
    
    
    
    /*******************************************************************************************************************
    *                                                      Type->is()
    *******************************************************************************************************************/


    /**
     * Test Type->is()
     * 
     * @dataProvider getIsData
     * 
     * @param Type   $type     Type to call is() on
     * @param string $typeName Type name to compare to
     * @param bool   $expected The expected result of calling $type->is()
     */
    public function testIs( Type $type, string $typeName, bool $expected )
    {
        $this->assertEquals(
            $expected,
            $type->is( $typeName ),
            'Type->is() did not return the correct value'
        );
    }


    /**
     * Data provider for is() test
     *
     * @return array
     **/
    public function getIsData(): array
    {
        return [
            'getByValue( 1 )->is( "int" )' => [
                TypeLookupSingleton::getInstance()->getByValue( 1 ),
                'int',
                true
            ],
            'getByValue( 1 )->is( "integer" )' => [
                TypeLookupSingleton::getInstance()->getByValue( 1 ),
                'integer',
                true
            ],
            'getByValue( 1 )->is( "integ" )' => [
                TypeLookupSingleton::getInstance()->getByValue( 1 ),
                'integ',
                false
            ],
            'getByValue( 1 )->is( "bool" )' => [
                TypeLookupSingleton::getInstance()->getByValue( 1 ),
                'bool',
                false
            ],
            'getByValue( 1 )->is( "boolean" )' => [
                TypeLookupSingleton::getInstance()->getByValue( 1 ),
                'boolean',
                false
            ]
        ];
    }




    /*******************************************************************************************************************
     *                                                Type->isValueOfType()
     ******************************************************************************************************************/
    
    
    
    
    /*******************************************************************************************************************
    *                                                    Type->isClass()
    *******************************************************************************************************************/
    
    
    /**
     * Ensure Type->isClass() returns false for basic types
     */
    public function testIsClassReturnsFalse()
    {
        $type = TypeLookupSingleton::getInstance()->getByValue( 1 );
        $this->assertFalse(
            $type->isClass(),
            'Expected Type->isClass() to return false for basic types'
        );
    }
    
    
    
    
    /*******************************************************************************************************************
    *                                                 Type->isInterface()
    *******************************************************************************************************************/
    
    
    /**
     * Ensure Type->isInterface() returns false for basic types
     */
    public function testIsInterfaceReturnsFalse()
    {
        $type = TypeLookupSingleton::getInstance()->getByValue( 1 );
        $this->assertFalse(
            $type->isInterface(),
            'Expected Type->isInterface() to return false for basic types'
        );
    }
}
