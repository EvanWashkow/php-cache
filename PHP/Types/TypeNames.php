<?php
declare( strict_types = 1 );

namespace PHP\Types;

/**
 * Defines list of known type names
 */
final class TypeNames
{
    /** @var string ARRAY The array type name */
    const ARRAY = 'array';

    /** @var string BOOL The boolean type name */
    const BOOL = 'bool';

    /** @var string BOOLEAN The (longer) boolean type name */
    const BOOLEAN = 'boolean';

    /** @var string DOUBLE Alternate name for a float */
    const DOUBLE = 'double';

    /** @var string FLOAT The float type name */
    const FLOAT = 'float';

    /** @var string FUNCTION The function type name */
    const FUNCTION = 'function';

    /** @var string INT The integer type name */
    const INT = 'int';

    /** @var string INTEGER The (longer) integer type name */
    const INTEGER = 'integer';

    /** @var string UNKNOWN The unknown type name (http://php.net/manual/en/function.gettype.php) */
    const UNKNOWN = 'unknown type';

    /** @var string NULL The null type name (http://php.net/manual/en/language.types.null.php) */
    const NULL = 'null';

    /** @var string STRING The string type name */
    const STRING = 'string';
}
