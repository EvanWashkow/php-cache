<?php
declare(strict_types=1);

namespace PHP\Enums;

use PHP\Collections\Dictionary;

/**
 * Allows users to define (and select from) a strict set of constant integers
 */
abstract class IntegerEnum extends Enum
{

    /**
     * Modify Constants to only support integers
     * 
     * @internal Final: it is a strict requirement that all constants in a
     * Integer Enumeration should be integers.
     * 
     * @param array $constants This class's array of constants
     * @throws \DomainException On non-integer constant
     */
    final protected function __constructConstantsDictionary( array $constants )
    {
        $dictionary = new Dictionary( 'string', 'integer' );
        foreach ( $constants as $key => $value ) {
            if ( !is_int( $value )) {
                $class = get_class( $this );
                throw new \DomainException( "$class::$key must be a integer. All constants defined in a IntegerEnum must be integers." );
            }
            $dictionary->set( $key, $value );
        }
        return $dictionary;
    }


    /**
     * @see parent::getValue()
     * 
     * @internal Final: the returned value cannot be modified. It directly
     * correlates with other underlying methods.
     */
    final public function getValue(): int
    {
        return parent::getValue();
    }


    /**
     * @see parent::maybeGetValueException()
     */
    protected function maybeGetValueException( $value ): ?\Throwable
    {
        $exception = null;
        if ( is_int( $value )) {
            $exception = parent::maybeGetValueException( $value );
        }
        else {
            $exception = new \InvalidArgumentException(
                'Given value was not a integer.'
            );
        }
        return $exception;
    }
}
