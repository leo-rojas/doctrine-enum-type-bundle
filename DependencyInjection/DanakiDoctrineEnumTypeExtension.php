<?php

namespace Danaki\DoctrineEnumTypeBundle\DependencyInjection;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\DependencyInjection\ConfigurableExtension;

class DanakiDoctrineEnumTypeExtension extends ConfigurableExtension
{
    protected function loadInternal(array $config, ContainerBuilder $container)
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

        $container->setParameter('danaki_doctrine_enum_type.types', $config['types']);
    }
}
