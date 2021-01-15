<?php

namespace Danaki\DoctrineEnumTypeBundle;

use Doctrine\DBAL\Types\Type;
use Symfony\Component\HttpKernel\Bundle\Bundle;

class DanakiDoctrineEnumTypeBundle extends Bundle
{
    public function boot()
    {

        foreach ($this->container->getParameter('danaki_doctrine_enum_type.types') as $typeName => $enumConfig) {
            $typeName = \is_string($typeName) ? $typeName : $enumConfig['enumClass'];
            $typeClass = $enumConfig['typeClass'];
            $enumClass = $enumConfig['enumClass'];
            if (! Type::hasType($typeName)) {
                $typeClass::registerEnumType($typeName, $enumClass);
            }
        }
    }
}
