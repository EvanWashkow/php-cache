<?php
declare( strict_types = 1 );

namespace PHP\Tests\Loops;

use PHP\Loops\Iterator;
use PHPUnit\Framework\TestCase;

/**
 * Tests the Iterator definition
 */
class IteratorTest extends TestCase
{




    /*******************************************************************************************************************
    *                                                     INHERITANCE
    *******************************************************************************************************************/


    /**
     * Ensure class implements the \Iterator interface
     */
    public function testIsIteratorInterface()
    {
        $iterator = $this->createMock( Iterator::class );
        $iterator->method( 'rewind' );

        $this->assertInstanceOf(
            \Iterator::class,
            $iterator,
            Iterator::class . ' is not an instance of \\Iterator.'
        );
    }




    /*******************************************************************************************************************
    *                                                         key()
    *******************************************************************************************************************/


    /**
     * Ensure key() returns the expected value
     * 
     * @dataProvider getKeyReturnValues
     */
    public function testKeyReturnValue( Iterator $iterator, $expected )
    {
        $this->assertEquals(
            $expected,
            $iterator->key(),
            'Iterator->key() returned the wrong value.'
        );
    }

    public function getKeyReturnValues(): array
    {
        return [

            'getKey() === 1' => [
                (function() {
                    $mock = $this->createMock( Iterator::class );
                    $mock->method( 'hasCurrent' )->willReturn( true );
                    $mock->method( 'getKey' )->willReturn( 1 );
                    return $mock;
                })(),
                1
            ],

            'getKey() === 2' => [
                (function() {
                    $mock = $this->createMock( Iterator::class );
                    $mock->method( 'hasCurrent' )->willReturn( true );
                    $mock->method( 'getKey' )->willReturn( 2 );
                    return $mock;
                })(),
                2
            ],

            'hasCurrent() === false' => [
                (function() {
                    $mock = $this->createMock( Iterator::class );
                    $mock->method( 'hasCurrent' )->willReturn( false );
                    $mock->method( 'getKey' )->willThrowException(
                        new \OutOfBoundsException( 'Key does not exist at this position.' )
                    );
                    return $mock;
                })(),
                null
            ]
        ];
    }




    /*******************************************************************************************************************
    *                                                         next()
    *******************************************************************************************************************/


    /**
     * Ensure next() forwards the call to goToNext()
     */
    public function testNext()
    {
        $isRun = false;
        $mock = $this->createMock( Iterator::class );
        $mock->method( 'goToNext' )->willReturnCallback( function() use ( &$isRun ) {
            $isRun = true;
        });
        $mock->next();

        $this->assertTrue(
            $isRun,
            'Iterator->next() did not call goToNext().'
        );
    }




    /*******************************************************************************************************************
    *                                                        valid()
    *******************************************************************************************************************/


    /**
     * Ensure valid() reflects hasCurrent()
     * 
     * @dataProvider getValidTestData
     */
    public function testValid( Iterator $iterator )
    {
        $this->assertTrue(
            $iterator->hasCurrent() === $iterator->valid(),
            'Iterator->valid() and Iterator->hasCurrent() should return the same result.'
        );
    }

    public function getValidTestData(): array
    {
        return [

            'hasCurrent() === true'  => [
                (function() {
                    $mock = $this->createMock( Iterator::class );
                    $mock->method( 'hasCurrent' )->willReturn( true );
                    return $mock;
                })()
            ],

            'hasCurrent() === false' => [
                (function() {
                    $mock = $this->createMock( Iterator::class );
                    $mock->method( 'hasCurrent' )->willReturn( false );
                    return $mock;
                })()
            ]
        ];
    }
}