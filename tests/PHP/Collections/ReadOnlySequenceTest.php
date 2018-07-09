<?php

use PHP\Collections\Sequence;
use PHP\Collections\ReadOnlySequence;

require_once( __DIR__ . '/../TestCase.php' );
require_once( __DIR__ . '/ReadOnlySequenceData.php' );

/**
 * Test all ReadOnlySequence methods to ensure consistent functionality
 *
 * This tests both the read-only and the editable sequnce (the read-only
 * simply invokes the editable)
 */
class ReadOnlySequenceTest extends \PHP\Tests\TestCase
{
    
    /***************************************************************************
    *                       ReadOnlySequence->toArray()
    ***************************************************************************/
    
    /**
     * Ensure ReadOnlySequence->toArray() returns an array
     */
    public function testToArrayReturnsArray()
    {
        foreach ( ReadOnlySequenceData::Get() as $sequence ) {
            $class = self::getClassName( $sequence );
            $this->assertTrue(
                is( $sequence->toArray(), 'array' ),
                "Expected {$class}->toArray() to return an array"
            );
        }
    }
    
    
    /**
     * Ensure ReadOnlySequence->toArray() has the same number of elements
     */
    public function testToArrayHasSameCount()
    {
        foreach ( ReadOnlySequenceData::Get() as $sequence ) {
            $class = self::getClassName( $sequence );
            $this->assertEquals(
                $sequence->count(),
                count( $sequence->toArray() ),
                "Expected {$class}->toArray() to have the same number of elements"
            );
        }
    }
    
    
    
    
    /***************************************************************************
    *                      ReadOnlySequence->getFirstKey()
    ***************************************************************************/
    
    /**
     * Ensure ReadOnlySequence->getFirstKey() returns zero
     */
    public function testGetFirstKeyReturnsZero()
    {
        foreach ( ReadOnlySequenceData::Get() as $sequence ) {
            $class = self::getClassName( $sequence );
            $this->assertTrue(
                0 === $sequence->getFirstKey(),
                "Expected {$class}->getFirstKey() to return zero"
            );
        }
    }
    
    
    
    
    /***************************************************************************
    *                      ReadOnlySequence->getLastKey()
    ***************************************************************************/
    
    /**
     * Ensure ReadOnlySequence->getLastKey() returns an integer value
     */
    public function testGetFirstKeyReturnsInt()
    {
        foreach ( ReadOnlySequenceData::Get() as $sequence ) {
            $class = self::getClassName( $sequence );
            $this->assertTrue(
                is( $sequence->getLastKey(), 'integer' ),
                "Expected {$class}->getLastKey() to return an integer value"
            );
        }
    }
    
    
    /**
     * Ensure ReadOnlySequence->getLastKey() is larger than or equalt to the
     * first for non-empty
     */
    public function testGetLastKeyIsGreaterThanOrEqualToFirstForNonEmpty()
    {
        foreach ( ReadOnlySequenceData::GetNonEmpty() as $sequence ) {
            $class = self::getClassName( $sequence );
            $this->assertGreaterThanOrEqual(
                $sequence->getFirstKey(),
                $sequence->getLastKey(),
                "Expected {$class}->getLastKey() to be greater than or equal to the first key for non-empty sequences"
            );
        }
    }
    
    
    /**
     * Ensure ReadOnlySequence->getLastKey() is less than first for empty
     */
    public function testGetLastKeyIsLessThanFirstForEmpty()
    {
        foreach ( ReadOnlySequenceData::GetEmpty() as $sequence ) {
            $class = self::getClassName( $sequence );
            $this->assertLessThan(
                $sequence->getFirstKey(),
                $sequence->getLastKey(),
                "Expected {$class}->getLastKey() to be less than the first key for empty sequences"
            );
        }
    }
    
    
    
    
    /***************************************************************************
    *                      ReadOnlySequence->getKeyOf()
    ***************************************************************************/
    
    
    /**
     * Ensure ReadOnlySequence->getKeyOf() returns a bad key on empty data
     */
    public function testGetKeyOfReturnsBadKeyOnEmptyData()
    {
        foreach ( ReadOnlySequenceData::GetEmpty() as $sequence ) {
            $class = self::getClassName( $sequence );
            $this->assertLessThan(
                $sequence->getFirstKey(),
                $sequence->getKeyOf( 'foobar' ),
                "Expected {$class}->getKeyOf() to return a bad key on empty data"
            );
        }
    }
    
    
    /**
     * Ensure ReadOnlySequence->getKeyOf() errors on too small of an offset
     */
    public function testGetKeyOfErrorsOnOffsetTooSmall()
    {
        foreach ( ReadOnlySequenceData::GetNonEmpty() as $sequence ) {
            $isError = false;
            try {
                $sequence->getKeyOf( 'foobar', $sequence->getFirstKey() - 1 );
            } catch (\Exception $e) {
                $isError = true;
            }
            $class = self::getClassName( $sequence );
            $this->assertTrue(
                $isError,
                "Expected {$class}->getKeyOf() to error when given an offset position too small"
            );
        }
    }
    
    
    /**
     * Ensure ReadOnlySequence->getKeyOf() errors on too large of an offset
     */
    public function testGetKeyOfErrorsOnOffsetTooLarge()
    {
        foreach ( ReadOnlySequenceData::GetNonEmpty() as $sequence ) {
            $isError = false;
            try {
                $sequence->getKeyOf( 'foobar', $sequence->getLastKey() + 1 );
            } catch (\Exception $e) {
                $isError = true;
            }
            $class = self::getClassName( $sequence );
            $this->assertTrue(
                $isError,
                "Expected {$class}->getKeyOf() to error when given an offset position too large"
            );
        }
    }
    
    
    
    
    /***************************************************************************
    *               ReadOnlySequence->getKeyOf() (string data)
    ***************************************************************************/
    
    /**
     * Ensure ReadOnlySequence->getKeyOf() returns key of the first value
     */
    public function testGetKeyOfStringValueReturnsFirstValueKey()
    {
        foreach ( self::getKeyOfStringData() as $sequence ) {
            $class = self::getClassName( $sequence );
            $this->assertTrue(
                0 === $sequence->getKeyOf( '0' ),
                "Expected {$class}->getKeyOf() to return the key of the first value"
            );
        }
    }
    
    
    /**
     * Ensure ReadOnlySequence->getKeyOf() returns key of offset value
     */
    public function testGetKeyOfStringValueReturnsKeyOfOffsetSearch()
    {
        foreach ( self::getKeyOfStringData() as $sequence ) {
            $class = self::getClassName( $sequence );
            $this->assertTrue(
                3 === $sequence->getKeyOf( '0', 1 ),
                "Expected {$class}->getKeyOf() to return the key of the offset value"
            );
        }
    }
    
    
    /**
     * Ensure ReadOnlySequence->getKeyOf() returns key of a reverse search
     */
    public function testGetKeyOfStringValueReturnsKeyOfReverseSearch()
    {
        foreach ( self::getKeyOfStringData() as $sequence ) {
            $class = self::getClassName( $sequence );
            $this->assertTrue(
                4 === $sequence->getKeyOf( '0', 0, true ),
                "Expected {$class}->getKeyOf() to return the key of the value when searching in reverse"
            );
        }
    }
    
    
    /**
     * Ensure ReadOnlySequence->getKeyOf() returns key in a reversed, offset search
     */
    public function testGetKeyOfStringValueReturnsKeyOfReverseOffsetSearch()
    {
        foreach ( self::getKeyOfStringData() as $sequence ) {
            $class = self::getClassName( $sequence );
            $this->assertTrue(
                3 === $sequence->getKeyOf( '0', 2, true ),
                "Expected {$class}->getKeyOf() to return the key of the value when searching in reverse with offset"
            );
        }
    }
    
    
    /**
     * Retrieves test data for getKeyOf() string tests
     *
     * @return array
     */
    public static function getKeyOfStringData(): array
    {
        // Variables
        $sequences = [];
        
        // Build test string Sequences
        $sequence = new Sequence( 'string' );
        $sequence->add( '0' );
        $sequence->add( '1' );
        $sequence->add( '1' );
        $sequence->add( '0' );
        $sequence->add( '0' );
        $sequence->add( '1' );
        $sequences[] = $sequence;
        $sequences[] = new ReadOnlySequence( $sequence );
        
        return $sequences;
    }
}
