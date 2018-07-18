<?php

use PHP\Collections\Sequence;

require_once( __DIR__ . '/SequenceData.php' );
require_once( __DIR__ . '/CollectionTestCase.php' );
require_once( __DIR__ . '/CollectionTestData.php' );

/**
 * Test all Sequence methods to ensure consistent functionality
 */
class SequenceTest extends CollectionTestCase
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
     * Ensure Sequence->insert() has the inserted value at the beginning of the
     * sequence
     */
    public function testInsertAtBeginning()
    {
        $values = CollectionTestData::Get();
        foreach ( self::GetInstances() as $type => $sequences ) {
            $value = $values[ $type ][ 0 ];
            foreach ( $sequences as $sequence ) {
                $key   = $sequence->getFirstKey();
                $class = self::getClassName( $sequence );
                $sequence->insert( $key, $value );
                $this->assertEquals(
                    $value,
                    $sequence->get( $key ),
                    "Expected {$class}->insert() to have the inserted value at the beginning of the sequence"
                );
            }
        }
    }
    
    
    /**
     * Ensure Sequence->insert() has the inserted value at the end of the
     * sequence
     */
    public function testInsertAtEnd()
    {
        $values = CollectionTestData::Get();
        foreach ( self::GetInstances() as $type => $sequences ) {
            $value = $values[ $type ][ 0 ];
            foreach ( $sequences as $sequence ) {
                $key   = $sequence->getLastKey() + 1;
                $class = self::getClassName( $sequence );
                $sequence->insert( $key, $value );
                $this->assertEquals(
                    $value,
                    $sequence->get( $key ),
                    "Expected {$class}->insert() to have the inserted value at the end of the sequence"
                );
            }
        }
    }
    
    
    /**
     * Ensure Sequence->insert() shifts values
     */
    public function testInsertShiftsValues()
    {
        $values = CollectionTestData::Get();
        foreach ( self::GetInstances() as $type => $sequences ) {
            foreach ( $sequences as $sequence ) {
                if ( 0 === $sequence->count() ) {
                    continue;
                }
                $value         = $values[ $type ][ 0 ];
                $key           = $sequence->getFirstKey();
                $previousValue = $sequence->get( $key );
                $class         = self::getClassName( $sequence );
                $sequence->insert( $key, $value );
                $this->assertEquals(
                    $previousValue,
                    $sequence->get( $key + 1 ),
                    "Expected {$class}->insert() shifts values"
                );
            }
        }
    }
    
    
    /**
     * Ensure Sequence->insert() errors on key too small
     */
    public function testInsertErrorsOnKeyTooSmall()
    {
        $values = CollectionTestData::Get();
        foreach ( self::GetInstances() as $type => $sequences ) {
            $typeValues = $values[ $type ];
            foreach ( $sequences as $sequence ) {
                $isError = false;
                try {
                    $sequence->insert( $sequence->getFirstKey() - 1, $typeValues[0] );
                } catch (\Exception $e) {
                    $isError = true;
                }
                $class = self::getClassName( $sequence );
                $this->assertTrue(
                    $isError,
                    "Expected {$class}->insert() to error on key too small"
                );
            }
        }
    }
    
    
    /**
     * Ensure Sequence->insert() errors on key too large
     */
    public function testInsertErrorsOnKeyTooLarge()
    {
        $values = CollectionTestData::Get();
        foreach ( self::GetInstances() as $type => $sequences ) {
            $typeValues = $values[ $type ];
            foreach ( $sequences as $sequence ) {
                $isError = false;
                try {
                    $sequence->insert( $sequence->getLastKey() + 2, $typeValues[0] );
                } catch (\Exception $e) {
                    $isError = true;
                }
                $class = self::getClassName( $sequence );
                $this->assertTrue(
                    $isError,
                    "Expected {$class}->insert() to error on key too large"
                );
            }
        }
    }
    
    
    
    
    /***************************************************************************
    *                                  DATA
    ***************************************************************************/
    
    
    /**
     * Retrieve test instances
     *
     * @return array
     */
    final public static function GetInstances(): array
    {
        $instances = [];
        foreach ( CollectionTestData::Get() as $type => $values ) {
            $sequence = new Sequence( $type );
            foreach ( $values as $value ) {
                $sequence->add( $value );
            }
            
            $instances[ $type ]   = [];
            $instances[ $type ][] = new Sequence( $type );
            $instances[ $type ][] = $sequence;
        }
        return $instances;
    }
}
