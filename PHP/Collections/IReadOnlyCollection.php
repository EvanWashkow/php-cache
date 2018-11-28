<?php
namespace PHP\Collections;

use PHP\Types\Models\Type;

/**
 * Specifications for an iterable set of read-only, key-value pairs
 */
interface IReadOnlyCollection extends \Countable, IIterator
{
    
    /**
     * Duplicate every key and value into a new instance
     *
     * @return IReadOnlyCollection
     */
    public function clone(): IReadOnlyCollection;
    
    /**
     * Retrieve the value stored at the specified key
     *
     * @param mixed $key The key to retrieve the value from
     * @return mixed The value if the key exists. NULL otherwise.
     */
    public function get( $key );
    
    /**
     * Retrieve all entry keys
     *
     * @return Sequence
     */
    public function getKeys(): Sequence;

    /**
     * Retrieve key type
     * 
     * @return Type
     **/
    public function getKeyType(): Type;
    
    /**
     * Retrieve all entry values
     *
     * @return Sequence
     */
    public function getValues(): Sequence;

    /**
     * Retrieve value type
     * 
     * @return Type
     **/
    public function getValueType(): Type;
    
    /**
     * Determine if the key exists
     *
     * @param mixed $key The key to check for
     * @return bool
     */
    public function hasKey( $key ): bool;

    /**
     * Determine if the value exists
     *
     * @param mixed $value The value to check for
     * @return bool
     */
    public function hasValue( $value ): bool;
    
    /**
     * Determine if the key type is valid for the collection
     *
     * @param mixed $key The key to check
     * @return bool
     */
    public function isOfKeyType( $key ): bool;
    
    /**
     * Determine if the value type is valid for the collection
     *
     * @param mixed $value The value to check
     * @return bool
     */
    public function isOfValueType( $value ): bool;
}
