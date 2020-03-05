<?php
namespace PHP\Tests\Types\Models;

use PHP\Tests\Types\TypeTestCase;
use PHP\Types\Models\FunctionType;
use PHP\Types\TypeNames;

/**
 * Tests the \PHP\Types\FunctionType functionality
 */
class FunctionTypeTest extends TypeTestCase
{
    
    
    /*******************************************************************************************************************
    *                                                     Type->equals()
    *******************************************************************************************************************/
    
    
    /**
     * Ensure Type->equals() returns true for a FunctionType
     */
    public function testEqualsForFunctionType()
    {
        $functionType = $this->getFunctionType();
        $this->assertTrue(
            $functionType->equals( $functionType ),
            "FunctionType->equals() should return return true for a Type instance"
        );
    }
    
    
    /**
     * Ensure Type->equals() returns false for different Type
     */
    public function testEqualsForDifferentType()
    {
        $this->assertFalse(
            $this->getFunctionType()->equals( $this->getTypeLookup()->getByName( 'null' ) ),
            "FunctionType->equals() should return false for the different Type instance"
        );
    }
    
    
    /**
     * Ensure Type->equals() returns false for a value of a different type
     */
    public function testEqualsForDifferentValueType()
    {
        $this->assertFalse(
            $this->getFunctionType()->equals( 'function' ),
            "FunctionType->equals() should return false for a value of a different type"
        );
    }




    /*******************************************************************************************************************
    *                                                    Type->getNames()
    *
    * Already tested in TypeLookupTest
    *******************************************************************************************************************/




    /*******************************************************************************************************************
    *                                                        Type->is()
    *******************************************************************************************************************/


    /**
     * Ensure all is() returns true for 'function'
     **/
    public function testIs()
    {
        $this->assertTrue(
            $this->getFunctionType()->is( TypeNames::FUNCTION ),
            "FunctionType->is( 'function' ) should return true"
        );
    }




    /*******************************************************************************************************************
    *                                                           DATA
    *******************************************************************************************************************/


    /**
     * Provides types for testing
     *
     * @return FunctionType
     **/
    public function getFunctionType(): FunctionType
    {
        static $functionType = null;
        if ( null === $functionType ) {
            $functionType = $this->getTypeLookup()->getByName( TypeNames::FUNCTION );
        }
        return $functionType;
    }
}