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
                                return ['enumClass' => $v, 'typeClass' => PhpEnumType::class];
                            })
                        ->end()
                        ->children()
                            ->scalarNode('enumClass')->isRequired()->end()
                            ->scalarNode('typeClass')->isRequired()->end()
                        ->end()
                    ->end()
                ->end()
            ->end()
        ->end();

        return $treeBuilder;
    }
}
