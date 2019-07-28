<?php
declare( strict_types = 1 );

namespace PHP\Types\Models;

/**
 * Store and retrieve type information for a class
 */
final class ClassType extends InterfaceType
{


    /**
     * @internal Final: this class will always be a class.
     */
    final public function isClass(): bool
    {
        return true;
    }


    /**
     * @internal Final: this class can never be an interface.
     */
    final public function isInterface(): bool
    {
        return false;
    }
}