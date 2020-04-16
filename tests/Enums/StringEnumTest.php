<?php
declare(strict_types=1);

namespace PHP\Tests\Enums;

use PHP\Interfaces\IStringable;
use PHP\Tests\Enums\TestEnumDefinitions\GoodStringEnum;
use PHPUnit\Framework\TestCase;

/**
 * Test the StringEnum class
 */
class StringEnumTest extends TestCase
{


    /**
     * Ensure that StringEnum is IStringable
     * 
     * @return void
     */
    public function testIsIStringable(): void
    {
        $this->assertInstanceOf(
            IStringable::class,
            new GoodStringEnum( GoodStringEnum::ONE ),
            'StringEnum is not IStringable.'
        );
    }


    /**
     * Ensure that StringEnum->__toString() returns the current value
     * 
     * @return void
     */
    public function testToString(): void
    {
        $this->assertTrue(
            ( string )( new GoodStringEnum( GoodStringEnum::ONE )) === GoodStringEnum::ONE,
            'StringEnum->__toString() did not return the current value.'
        );
    }
}
