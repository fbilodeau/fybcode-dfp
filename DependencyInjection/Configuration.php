<?php

namespace Fybcode\DfpBundle\DependencyInjection;

use Symfony\Component\Config\Definition\ConfigurationInterface;
use Symfony\Component\Config\Definition\Builder\TreeBuilder;

/**
 * This is the class that validates and merges configuration from your app/config files
 *
 * @package     FybcodeDfpBundle
 * @author      Francis Bilodeau <fbilodeau@dessinsdrummond.com>
 * @copyright   (c) 2017 Francis Bilodeau
 */
class Configuration implements ConfigurationInterface
{
    /**
     * {@inheritDoc}
     */
    public function getConfigTreeBuilder()
    {
        $builder = new TreeBuilder('fybcode_dfp');
        if (\method_exists($builder, 'getRootNode')) {
            $rootNode = $builder->getRootNode();
        } else {
            // BC layer for symfony/config 4.1 and older
            $rootNode = $builder->root('fybcode_dfp', 'array');
        }

        $rootNode
            ->children()
                ->scalarNode('publisher_id')->isRequired()->cannotBeEmpty()->end()
                ->scalarNode('div_class')->defaultValue('dfp-ad-unit')->end()
            ->end()
        ;

        return $builder;
    }
}

