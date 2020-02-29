<?php
declare( strict_types = 1 );

namespace PHP\Types;

use PHP\Types\Models\ClassType;
use PHP\Types\Models\FunctionType;
use PHP\Types\Models\InterfaceType;
use PHP\Types\Models\Type;
use PHP\Types\TypeNames;

/**
 * Retrieves type information based on the type name or value
 */
class TypeLookup
{




    /*******************************************************************************************************************
    *                                                   LOOKUP METHODS
    *******************************************************************************************************************/


    /**
     * Lookup Type information by its name
     *
     * @param string $typeName The type name
     * @return Type
     * @throws \DomainException
     */
    public function getByName( string $typeName ): Type
    {
        // Type result
        $type = null;


        /**
         * Primitive Types
         */
        switch ( $typeName )
        {
            case TypeNames::ARRAY:
                $type = $this->createArrayType();
                break;

            case TypeNames::BOOL:
            case TypeNames::BOOLEAN:
                $type = $this->createBooleanType();
                break;

            case TypeNames::DOUBLE:
            case TypeNames::FLOAT:
                $type = $this->createFloatType();
                break;

            case TypeNames::FUNCTION:
                $type = $this->createFunctionType();
                break;

            case TypeNames::INT:
            case TypeNames::INTEGER:
                $type = $this->createIntegerType();
                break;

            case TypeNames::NULL:
                $type = $this->createNullType();
                break;

            case TypeNames::STRING:
                $type = $this->createStringType();
                break;

            default:
                break;
        }


        /**
         * Exit. Primitive type was found. No need for further processing.
         */
        if ( $type instanceof Type ) {
            return $type;
        }


        /**
         * Advanced types
         */
        if ( function_exists( $typeName )) {
            $type = $this->createFunctionInstanceType( new \ReflectionFunction( $typeName ) );
        }
        elseif ( interface_exists( $typeName )) {
            $type = $this->createInterfaceType( new \ReflectionClass( $typeName ) );
        }
        elseif ( class_exists( $typeName )) {
            $type = $this->createClassType( new \ReflectionClass( $typeName ) );
        }


        /**
         * @throws \DomainException
         */
        else {
            throw new \DomainException( "Type does not exist for the type name \"{$typeName}\"" );
        }

        return $type;
    }




    /*******************************************************************************************************************
    *                                               PRIMITIVE TYPE FACTORIES
    *******************************************************************************************************************/


    /**
     * Create an Array type instance
     * 
     * @return Type
     */
    protected function createArrayType(): Type
    {
        return new Type( TypeNames::ARRAY );
    }


    /**
     * Create a Boolean type instance
     * 
     * @return Type
     */
    protected function createBooleanType(): Type
    {
        return new Type( TypeNames::BOOL, [ TypeNames::BOOLEAN ] );
    }


    /**
     * Create a Float type instance
     * 
     * @return Type
     */
    protected function createFloatType(): Type
    {
        return new Type( TypeNames::FLOAT, [ TypeNames::DOUBLE ] );
    }


    /**
     * Create a Integer type instance
     * 
     * @return Type
     */
    protected function createIntegerType(): Type
    {
        return new Type( TypeNames::INT, [ TypeNames::INTEGER ] );
    }


    /**
     * Create a Null type instance
     * 
     * @return Type
     */
    protected function createNullType(): Type
    {
        return new Type( TypeNames::NULL );
    }


    /**
     * Create a String type instance
     * 
     * @return Type
     */
    protected function createStringType(): Type
    {
        return new Type( TypeNames::STRING );
    }




    /*******************************************************************************************************************
    *                                               FUNCTION TYPE FACTORIES
    *******************************************************************************************************************/


    /**
     * Create a Function type instance
     * 
     * @return Type
     */
    protected function createFunctionType(): Type
    {
        return new Type( TypeNames::FUNCTION );
    }


    /**
     * Create a FunctionType instance
     * 
     * @param \ReflectionFunction $function The ReflectionFunction instance for the function instance
     * @return Type
     */
    protected function createFunctionInstanceType( \ReflectionFunction $function ): FunctionType
    {
        return new FunctionType( $function );
    }




    /*******************************************************************************************************************
    *                                           INTERFACE / CLASS TYPE FACTORIES
    *******************************************************************************************************************/


    /**
     * Create a Interface type instance
     * 
     * @param \ReflectionClass $interface The ReflectionClass instance for the interface
     * @return InterfaceType
     */
    protected function createInterfaceType( \ReflectionClass $interface ): InterfaceType
    {
        return new InterfaceType( $interface );
    }


    /**
     * Create a Class type instance
     * 
     * @param \ReflectionClass $class The ReflectionClass instance for the class
     * @return ClassType
     */
    protected function createClassType( \ReflectionClass $class ): ClassType
    {
        return new ClassType( $class );
    }
}
