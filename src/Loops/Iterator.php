<?php
declare( strict_types = 1 );

namespace PHP\Loops;

use PHP\Exceptions\NotImplementedException;

/**
 * Traverses an Iterable item in a foreach() loop, retrieving that item's key and value.
 */
abstract class Iterator implements \Iterator
{

    /**
     * @internal Initialize starting position here, rather than the constructor.
     */
    abstract public function rewind(): void;


    /**
     * Determines if there is a current item (with a key and value)
     * 
     * @return bool
     */
    abstract public function hasCurrent(): bool;


    /**
     * Retrieve the key for the current item
     * 
     * @return scalar
     * @throws \OutOfBoundsException If the current position is invalid
     */
    abstract public function getKey();


    /**
     * Retrieve the value for the current item
     * 
     * @return mixed
     * @throws \OutOfBoundsException If the current position is invalid
     */
    abstract public function getValue();


    /**
     * Proceed to the next item (regardless if it exists or not)
     * 
     * @internal This is one of the inherit design flaws of PHP: you must increment to an invalid position and then
     * report it as such. This is why hasCurrent() was added for validating the current position, why getKey() and
     * getValue() throw \OutOfBoundExceptions, and why this interim class was added. Unfortunately, this design problem
     * cannot be solved in a child implementation.
     * 
     * @return void
     */
    abstract public function goToNext(): void;


    final public function current()
    {
        throw new NotImplementedException( __FUNCTION__ . '() is not implemented, yet.' );
    }


    final public function key()
    {
        throw new NotImplementedException( __FUNCTION__ . '() is not implemented, yet.' );
    }


    final public function next(): void
    {
        throw new NotImplementedException( __FUNCTION__ . '() is not implemented, yet.' );
    }


    final public function valid(): bool
    {
        throw new NotImplementedException( __FUNCTION__ . '() is not implemented, yet.' );
    }
}