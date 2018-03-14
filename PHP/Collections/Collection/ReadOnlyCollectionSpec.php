<?php
namespace PHP\Collections\Collection;

use PHP\Collections\IterableSpec;

/**
 * Defines the type for a set of indexed, read-only values
 */
interface ReadOnlyCollectionSpec extends IterableSpec
{

    /**
     * Duplicate every index and value into a new instance
     *
     * @return ReadOnlyCollectionSpec
     */
    public function Clone(): ReadOnlyCollectionSpec;
    
    /**
     * Convert to a native PHP array
     *
     * @return array
     */
    public function ConvertToArray(): array;
    
    /**
     * Count all entries, returning the result
     *
     * @return int
     */
    public function Count(): int;
    
    /**
     * Retrieve the value stored at the specified index
     *
     * @param mixed $index        The index to retrieve the value from
     * @param mixed $defaultValue The value to return if the index does not exist
     * @return mixed The value if the index exists. NULL otherwise.
     */
    public function Get( $index, $defaultValue = null );
    
    /**
     * Determine if the index exists
     *
     * @param mixed $index The index to check
     * @return bool
     */
    public function HasIndex( $index ): bool;
}
