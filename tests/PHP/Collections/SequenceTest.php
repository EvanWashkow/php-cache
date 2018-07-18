<?php

use PHP\Collections\Sequence;
use PHP\Tests\Collections\TestData;

require_once( __DIR__ . '/CollectionsTestCase.php' );
require_once( __DIR__ . '/SequenceData.php' );
require_once( __DIR__ . '/TestData.php' );

/**
 * Test all Sequence methods to ensure consistent functionality
 */
class SequenceTest extends \PHP\Tests\Collections\CollectionsTestCase
{
    
    /***************************************************************************
    *                            Sequence->add()
    ***************************************************************************/
    
    
    /**
     * Ensure Sequence->add() has a higher count
     */
    public function testAddHasHigherCount()
    {
        foreach ( SequenceData::Get() as $sequence ) {
            if ( 0 === $sequence->count() ) {
                continue;
            }
            $before = $sequence->count();
            $sequence->add( $sequence->get( $sequence->getLastKey() ));
            $class = self::getClassName( $sequence );
            $this->assertGreaterThan(
                $before,
                $sequence->count(),
                "Expected {$class}->add() to have a higher count"
            );
        }
    }
    
    
    /**
     * Ensure Sequence->add() has a higher count
     */
    public function testAddErrorsOnWrongType()
    {
        foreach ( SequenceData::GetTyped() as $sequence ) {
            if ( 0 === $sequence->count() ) {
                continue;
            }
            $isError = false;
            try {
                $sequence->add( $sequence->getFirstKey() );
            }
            catch ( \Exception $e ) {
                $isError = true;
            }
            $class = self::getClassName( $sequence );
            $this->assertTrue(
                $isError,
                "Expected {$class}->add() to error on the wrong type"
            );
        }
    }
    
    
    /**
     * Ensure Sequence->add() has the same value at the end
     */
    public function testAddValueIsSame()
    {
        foreach ( SequenceData::Get() as $sequence ) {
            if ( 0 === $sequence->count() ) {
                continue;
            }
            $value = $sequence->get( $sequence->getLastKey() );
            $sequence->add( $value );
            $class = self::getClassName( $sequence );
            $this->assertTrue(
                $value === $sequence->get( $sequence->getLastKey() ),
                $sequence->count(),
                "Expected {$class}->add() to have the same value at the end"
            );
        }
    }
    
    
    /**
     * Ensure Sequence->add() has same value on empty
     */
    public function testAddValueIsSameOnEmpty()
    {
        foreach ( SequenceData::Get() as $sequence ) {
            if ( 0 === $sequence->count() ) {
                continue;
            }
            $value = $sequence->get( $sequence->getLastKey() );
            $sequence->clear();
            $sequence->add( $value );
            $class = self::getClassName( $sequence );
            $this->assertTrue(
                $value === $sequence->get( $sequence->getLastKey() ),
                $sequence->count(),
                "Expected {$class}->add() to have the same value on empty"
            );
        }
    }
    
    
    
    
    /***************************************************************************
    *                            Sequence->insert()
    ***************************************************************************/
    
    
    /**
     * Ensure Sequence->insert() has entries
     */
    public function testInsertHasEntries()
    {
        foreach ( TestData::Get() as $type => $values ) {
            $sequence = new Sequence( $type );
            $sequence->insert( 0, $values[0] );
            $sequence->insert( 1, $values[1] );
            $this->assertEquals(
                2,
                $sequence->count(),
                "Expected Sequence->insert() to have entries"
            );
        }
    }
}
