<?php

namespace Danaki\DoctrineEnumTypeBundle;

use Doctrine\DBAL\Types\Type;
use Symfony\Component\HttpKernel\Bundle\Bundle;

class DanakiDoctrineEnumTypeBundle extends Bundle
{
    public function boot()
    {
        // Merge types and custom types
        if (!empty($config['custom_types'])) {
            foreach ($config['custom_types'] as $customPhpEnumTypeClass => $customTypes) {
                foreach ($customTypes as $enumTypeName => $enumClass) {
                    $typeName = is_string($enumTypeName) ? $enumTypeName : $enumClass;
                    $config['types'][$typeName] = [
                        'enum_class' => $enumClass,
                        'type_class' => $customPhpEnumTypeClass
                    ];
                }
            }
        }

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
