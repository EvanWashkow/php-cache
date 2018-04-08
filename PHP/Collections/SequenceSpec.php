<?php
namespace PHP\Collections;

use PHP\Collections\Sequence\ReadOnlySequenceSpec;
use PHP\Collections\Collection\ReadOnlyCollectionSpec;

/**
 * Specifications for a mutable, ordered, and iterable set of key-value pairs
 */
interface SequenceSpec extends CollectionSpec, ReadOnlySequenceSpec
{
    
    /**
     * Store the value at the end of the sequence
     *
     * @param mixed $value The value to add
     * @return bool Whether or not the operation was successful
     */
    public function add( $value ): bool;
    
    /**
     * Duplicate every key and value into a new instance
     *
     * @return SequenceSpec
     */
    public function clone(): ReadOnlyCollectionSpec;
    
    /**
     * Insert the value at the key, shifting remaining values up
     *
     * @param int   $key The key to insert the value at
     * @param mixed $value The value
     * @return bool Whether or not the operation was successful
     */
    public function insert( int $key, $value ): bool;
    
    /**
     * Put all entries in reverse order
     */
    public function reverse();
    
    /**
     * Clone a subset of entries from this sequence
     *
     * @param int $start Starting key (inclusive)
     * @param int $end   Ending key (inclusive)
     * @return SequenceSpec
     */
    public function slice( int $start, int $end ): ReadOnlySequenceSpec;
    
    /**
     * Chop these entries into groups, using the given value as a delimiter
     *
     * Since this is similar to cloning, the returned value will be of the same
     * type as the originating sequence
     *
     * @param mixed $delimiter Value separating each group
     * @param int   $limit     Maximum number of entries to return; negative to return all.
     * @return SequenceSpec
     */
    public function split( $delimiter, int $limit = -1 ): ReadOnlySequenceSpec;
}
