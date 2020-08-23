<?php
declare( strict_types = 1 );

namespace PHP\Tests\Interfaces;

use PHP\Interfaces\IEquatable;

/**
 * Tests for IEquatable implementors
 */
trait IEquatableTestTrait
{


    /**
     * Test IEquatable->equals() returns the expected result
     * 
     * @dataProvider getEqualsTestData()
     * 
     * @param IEquatable $equatable The IEquatable to do the comparison
     * @param mixed      $value      The value to compare to
     * @param bool       $expected   The expected result of equatable->equals()
     * @return void
     */
    final public function testEquals( IEquatable $equatable, $value, bool $expected ): void
    {
        $this->assertEquals(
            $expected,
            $equatable->equals( $value ),
            'equatable->equals( value ) did not return the expected results.'
        );
    }


    /**
     * Test hash() by comparing its results
     * 
     * @dataProvider getHashTestData
     * 
     * @param IEquatable $equatable1 The first IEquatable
     * @param IEquatable $equatable2 The second IEquatable
     * @param bool       $expected   The expected result of equatable_1->hash() === equatable_2->hash()
     * @return void
     */
    final public function testHash( IEquatable $equatable1, IEquatable $equatable2, bool $expected ): void
    {
        if ( $expected ) {
            $this->assertEquals(
                $equatable1->hash()->__toString(),
                $equatable2->hash()->__toString(),
                'equatable_1->hash() is not equal to equatable_2->hash(), but should not be.'
            );
        }
        else {
            $this->assertNotEquals(
                $equatable1->hash()->__toString(),
                $equatable2->hash()->__toString(),
                'equatable_1->hash() is equal to equatable_2->hash(), but should not be.'
            );
        }
    }


    /**
     * Tests the consistency of equals() and hash() as described on IEquatable
     * 
     * @dataProvider getEqualsAndHashConsistencyTestData
     * 
     * @param IEquatable $equatable1 The IEquatable to do the comparison
     * @param IEquatable $equatable2 The IEquatable to compare to
     * @return void
     */
    final public function testEqualsAndHashConsistency( IEquatable $equatable1, IEquatable $equatable2 ): void
    {
        $this->assertTrue(
            $equatable1->equals( $equatable2 ),
            'Equatable 1 must be equal to Equatable 2 to test Hash consistency.'
        );
        $this->assertEquals(
            $equatable1->hash()->__toString(),
            $equatable2->hash()->__toString(),
            'Equatable 1\'s hash must be equal to Equatable 2\'s hash.'
        );
    }
}