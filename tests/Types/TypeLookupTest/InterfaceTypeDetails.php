<?php
declare( strict_types = 1 );

namespace PHP\Tests\Types\TypeLookupTest;

use PHP\Types\Models\InterfaceType;
use PHP\Types\Models\Type;

class InterfaceTypeDetails implements IExpectedTypeDetails
{

    private $interfaceName;

    public function __construct( string $interfaceName )
    {
        $this->interfaceName = $interfaceName;
    }


    public function getTypeNames(): array
    {
        return [ $this->interfaceName ];
    }


    public function getTypeTypes(): array
    {
        return [ InterfaceType::class, Type::class ];
    }
}