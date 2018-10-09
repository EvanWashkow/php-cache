<?php
namespace PHP\Collections;

/**
 * Defines an iterable set of mutable, key-value pairs
 *
 * @see PHP\Collections\Iterator
 */
abstract class Collection extends Iterator implements ICollection
{
    
    /**
     * Type requirement for all keys
     *
     * @var string
     */
    private $keyTypeString;
    
    /**
     * Type requirement for all values
     *
     * @var string
     */
    private $valueTypeString;
    
    
    /**
     * Create a new Collection
     *
     * @param string $keyType Specifies the type requirement for all keys (see `is()`). An empty string permits all types. Must be 'string' or 'integer'.
     * @param string $valueType Specifies the type requirement for all values (see `is()`). An empty string permits all types.
     */
    public function __construct( string $keyType = '', string $valueType = '' )
    {
        // Sanitize
        $keyType   = trim( $keyType );
        $valueType = trim( $valueType );
        
        // Check for invalid value types
        if ( 'null' === strtolower( $keyType )) {
            throw new \Exception( 'Key types cannot be NULL' );
        }
        else if ( 'null' === strtolower( $valueType )) {
            throw new \Exception( 'Value types cannot be NULL' );
        }
        
        // Set properties
        $this->keyTypeString   = $keyType;
        $this->valueTypeString = $valueType;
    }
    
    
    final public function getKeys(): Sequence
    {
        $keys = new Sequence( $this->keyTypeString );
        $this->loop( function( $key, $value ) use ( &$keys ) {
            $keys->add( $key );
        });
        return $keys;
    }
    
    
    final public function getValues(): Sequence
    {
        $values = new Sequence( $this->valueTypeString );
        $this->loop( function( $key, $value ) use ( &$values ) {
            $values->add( $value );
        });
        return $values;
    }
    
    
    final public function isOfKeyType( $key ): bool
    {
        return (
            ( null !== $key ) &&
            (
                ( '' === $this->keyTypeString ) ||
                is( $key, $this->keyTypeString )
            )
        );
    }
    
    
    final public function isOfValueType( $value ): bool
    {
        return (( '' === $this->valueTypeString ) || is( $value, $this->valueTypeString ));
    }
    
    
    
    
    /***************************************************************************
    *                              ITERATOR METHODS
    ***************************************************************************/
    
    final public function seek( $key )
    {
        if ( $this->hasKey( $key )) {
            parent::seek( $key );
        }
        else {
            $this->throwSeekError( $key );
        }
    }
    
    
    final public function valid()
    {
        return $this->hasKey( $this->key() );
    }
}
