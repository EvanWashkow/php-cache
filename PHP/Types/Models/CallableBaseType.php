<?php
namespace PHP\Types\Models;

use PHP\Types\TypeNames;

/**
 * Defines the base type for an item that can be invoked like a function
 */
class CallableBaseType extends Type implements CallableType
{
    

    public function __construct( string $name    = TypeNames::CALLABLE,
                                 array  $aliases = [] )
    {
        $aliases[] = TypeNames::CALLABLE;
        parent::__construct( $name, $aliases );
    }
}
