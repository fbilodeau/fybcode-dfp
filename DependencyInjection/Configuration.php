<?php

namespace Fybcode\DfpBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;

/**
 * This is the class that validates and merges configuration from your app/config files
 *
 * @package     FybcodeDfpBundle
 * @author      Francis Bilodeau <fbilodeau@dessinsdrummond.com>
 * @copyright   (c) 2017 Francis Bilodeau
 */
class Configuration
{
    /**
     * {@inheritDoc}
     */
    public function getConfigTree()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('fybcode_dfp', 'array');

        $rootNode
            ->children()
                ->scalarNode('publisher_id')->isRequired()->cannotBeEmpty()->end()
                ->scalarNode('div_class')->defaultValue('dfp-ad-unit')->end()
            ->end()
        ;

        return $treeBuilder->buildTree();
    }
}

