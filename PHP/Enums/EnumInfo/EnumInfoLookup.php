<?php
declare(strict_types=1);

namespace PHP\Enums\EnumInfo;

use PHP\Enums\Enum;
use PHP\Exceptions\NotFoundException;
use PHP\Types;
use PHP\Types\Models\ClassType;

/**
 * Lookup details about an enumerated class
 * 
 * @internal This does not leverage any caching since, at its heart, this based
 * on the Types lookup system, which is already cached.
 */
class EnumInfoLookup
{


    /**
     * Create a lookup routine for enumerated classes
     */
    public function __construct()
    {
        return;
    }


    /**
     * Retrieve information about an Enumerated class
     * 
     * @internal This method standardizes and sanitizes the argument, throwing
     * Exceptions as necessary.
     * 
     * @param string|Enum $enum The Enum class name or instance
     * @return EnumInfo
     * @throws NotFoundExeption If the type does not exist
     * @throws \DomainException If the type exists, but is not an Enum
     * @throws \InvalidArgumentException If argument is not a string or Enum instance
     */
    public function get( $enum ): EnumInfo
    {
        /**
         * Convert the argument into the enum class name, throwing an
         * Invalid Argument Exception on an invalid argument.
         */

        // The enum class name
        $enumClassName = '';

        // Switch on type
        if ( $enum instanceof Enum ) {
            $enumClassName = get_class( $enum );
        }
        elseif ( is_string( $enum ) ) {
            $enumClassName = $enum;
        }
        else {
            throw new \InvalidArgumentException(
                'Enum class name or instance expected. None given.'
            );
        }


        /**
         * Check the Enum Type instance to ensure it is for an Enum class
         */

        // The Enum's Type
        $enumType = null;

        // Try to get the enum type
        try {
            $enumType = Types::GetByName( $enumClassName );
        } catch ( NotFoundException $e ) {
            throw new NotFoundException( $e->getMessage(), $e->getCode() );
        }

        // Throw DomainException if the Type is not a ClassType
        if ( ! $enumType instanceof ClassType ) {
            throw new \DomainException(
                "Enum class expected. \"{$enumType->getName()}\" is not a class."
            );
        }

        // Throw DomainException if the ClassType is not derived from the
        // Enum class
        elseif ( ! $enumType->is( Enum::class )) {
            throw new \DomainException(
                "Enum class expected. \"{$enumType->getName()}\" is not derived from the Enum class."
            );
        }


        /**
         * Return the Enum Info
         */
        return $this->createEnumInfoByClassType( $enumType );
    }


    /**
     * Create a new EnumInfo instance, by the Enum's ClassType
     * 
     * @internal Override this method if you want to return a custom EnumInfo
     * type. No exceptions should be thrown here, since the ClassType is already
     * ensured to be an Enum class.
     * 
     * @param ClassType $enumClassType The Enum's ClassType instance
     * @return EnumInfo
     */
    protected function createEnumInfoByClassType( ClassType $enumClassType ): EnumInfo
    {
        if ( $enumClassType->is( Enum::class )) {
            $enumInfo = new EnumInfo( $enumClassType );
        }
        return $enumInfo;
    }
}
