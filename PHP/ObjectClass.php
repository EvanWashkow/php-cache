<?php
declare( strict_types = 1 );

namespace PHP;

use PHP\Interfaces\Cloneable;
use PHP\Interfaces\Equatable;
use ReflectionClass;

/**
 * Defines a basic object
 */
class ObjectClass implements Cloneable, Equatable
{

    /**
     * Duplicate this object
     * 
     * @return static
     */
    public function clone(): Cloneable
    {
        return clone $this;
    }


    /**
     * Determine if this object equals another object
     * 
     * @internal Can't use "==" in any fashion. "==" implicitly converts
     * property types if they aren't typed, which gives the wrong result.
     * For example, Value->value = '1' and Value->value = 1 are considered equal
     * (==) to eachother, when they are not.
     * 
     * @internal Interesting to note, "===" returns "true" for two different
     * array instances which have the same values.
     * 
     * @param mixed $value The value to compare this Object to
     * 
     * @return bool
     */
    public function equals( $value ): bool
    {
        // Compare instances
        $equals = $this === $value;

        // If not equals, compare individual object properties
        if ( !$equals )
        {
            // Is $value derived from $this class? If not, false.
            $class = new ReflectionClass( $this );
            if ( is_a( $value, $class->getName() ) )
            {
                // For each of this class' properties, compare the two object's
                // values for those properties.
                $properties = $class->getProperties();
                foreach ( $properties as $property ) {
                    $property->setAccessible( true );
                    $thisPropValue  = $property->getValue( $this );
                    $valuePropValue = $property->getValue( $value );
                    $equals         = $thisPropValue === $valuePropValue;
                    if ( !$equals ) {
                        break;
                    }
                }
            }
        }

        return $equals;
    }
}