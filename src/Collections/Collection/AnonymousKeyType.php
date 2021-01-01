<?php
declare( strict_types = 1 );

namespace PHP\Collections\Collection;

use PHP\Types\Models\AnonymousType;
use PHP\Types\Models\Type;

/**
 * Anonymous type for keys that evaluates to true for any type other than null
 */
class AnonymousKeyType extends AnonymousType
{

    /**
     * @see Type->equals()
     */
    public function equals($value ): bool
    {
        $isEqual = true;
        if ( null === $value ) {
            $isEqual = false;
        }
        elseif ( is_a( $value, Type::class ) ) {
            $isEqual = !$value->is( 'null' );
        }
        return $isEqual;
    }


    /**
     * @see Type->is()
     */
    public function is( string $typeName ): bool
    {
        return 'null' !== $typeName;
    }
}
