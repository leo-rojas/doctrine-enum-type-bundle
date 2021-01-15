<?php

namespace Danaki\DoctrineEnumTypeBundle\DependencyInjection;

use Acelaya\Doctrine\Type\PhpEnumType;
use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

class Configuration implements ConfigurationInterface
{
    /**
     * {@inheritdoc}
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder('doctrine_enum_type');

        if (method_exists($treeBuilder, 'getRootNode')) {
            $rootNode = $treeBuilder->getRootNode();
        } else {
            // for symfony/config 4.1 and older
            $rootNode = $treeBuilder->root('doctrine_enum_type');
        }

        $rootNode->children()
                ->arrayNode('types')
                    ->useAttributeAsKey('name')
                    ->arrayPrototype()
                        ->beforeNormalization()
                            ->ifString()
                            ->then(function ($v) {
                                return ['enum_class' => $v, 'type_class' => PhpEnumType::class];
                            })
                        ->end()
                        ->children()
                            ->scalarNode('enum_class')->isRequired()->end()
                            ->scalarNode('type_class')->isRequired()->end()
                        ->end()
                    ->end()
                ->end()
                ->arrayNode('custom_types')
                    ->useAttributeAsKey('name')
                    ->arrayPrototype()
                        ->useAttributeAsKey('name')
                        ->prototype('scalar')->end()
                    ->end()
                ->end()
            ->end()
        ->end();

        return $treeBuilder;
    }
}
