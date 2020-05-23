<?php
declare( strict_types = 1 );

namespace PHP\Tests\Collections\Iterators;

use PHP\Collections\Iteration\ArrayableIterator;
use PHP\Collections\Iterators\SequenceIterator;
use PHP\Collections\Sequence;
use PHPUnit\Framework\TestCase;

/**
 * Tests SequenceIterator
 */
class SequenceIteratorTest extends TestCase
{




    /*******************************************************************************************************************
    *                                                      INHERITANCE
    *******************************************************************************************************************/


    /**
     * Ensure SequenceIterator is an instance of a ArrayableIterator
     */
    public function testIsArrayableIterator()
    {
        $this->assertInstanceOf(
            ArrayableIterator::class,
            new SequenceIterator( new Sequence( 'int' )),
            'SequenceIterator is not an ArrayableIterator instance.'
        );
    }




    /*******************************************************************************************************************
    *                                                     __construct()
    *******************************************************************************************************************/


    /**
     * Test __construct() correctly sets the starting index
     * 
     * @dataProvider getConstructStartingIndexTestData
     */
    public function testConstructStartingIndex( Sequence $sequence )
    {
        $this->assertEquals(
            $sequence->getFirstKey(),
            ( new SequenceIterator( $sequence ) )->getKey(),
            'SequenceIterator->getKey() did not return the Sequence->getFirstKey().'
        );
    }

    public function getConstructStartingIndexTestData()
    {
        return [
            'Sequence->getFirstKey() === -2' => [
                (function() {
                    $sequence = $this->createMock( Sequence::class );
                    $sequence->method( 'getFirstKey' )->willReturn( -2 );
                    return $sequence;
                })()
            ],
            'Sequence->getFirstKey() === 0' => [
                new Sequence( '*' )
            ],
            'Sequence->getFirstKey() === 3' => [
                (function() {
                    $sequence = $this->createMock( Sequence::class );
                    $sequence->method( 'getFirstKey' )->willReturn( 3 );
                    return $sequence;
                })()
            ]
        ];
    }




    /*******************************************************************************************************************
    *                                                       getValue()
    *******************************************************************************************************************/

    /**
     * Test getValue() return key
     * 
     * @dataProvider getSequenceIterators
     */
    public function testGetValue( SequenceIterator $iterator, bool $hasCurrent, int $key, ?int $value )
    {
        if ( null === $value ) {
            $this->expectException( \OutOfBoundsException::class );
            $iterator->getValue();
        }
        else {
            $this->assertEquals(
                $value,
                $iterator->getValue(),
                'SequenceIterator->getValue() did not return the expected value.'
            );
        }
    }




    /*******************************************************************************************************************
    *                                                       getKey()
    *******************************************************************************************************************/

    /**
     * Test getKey() return key
     * 
     * @dataProvider getSequenceIterators
     */
    public function testGetKey( SequenceIterator $iterator, bool $hasCurrent, int $key, ?int $value )
    {
        $this->assertEquals(
            $key,
            $iterator->getKey(),
            'SequenceIterator->getKey() did not return the expected value.'
        );
    }




    /*******************************************************************************************************************
    *                                                      hasCurrent()
    *******************************************************************************************************************/

    /**
     * Test hasCurrent() return value
     * 
     * @dataProvider getSequenceIterators
     */
    public function testHasCurrent( SequenceIterator $iterator, bool $hasCurrent, int $key, ?int $value )
    {
        $this->assertEquals(
            $hasCurrent,
            $iterator->hasCurrent(),
            'SequenceIterator->hasCurrent() did not return the expected value.'
        );
    }




    /*******************************************************************************************************************
    *                                                   SHARED DATA PROVIDERS
    *******************************************************************************************************************/


    /**
     * Retrieve sample SequenceIterator test data
     * 
     * @return array
     */
    public function getSequenceIterators(): array
    {
        return [

            // Simple SequenceIterator with no entries
            'SequenceIterator([]), zero-based index' => [
                new SequenceIterator( new Sequence( 'int' ) ),      // SequenceIterator
                false,                                              // ->hasCurrent()
                0,                                                  // ->getKey()
                null                                                // ->getValue()
            ]
        ];
    }
}