<?php

namespace AC\MediaInfoBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

class Configuration implements ConfigurationInterface
{

    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('ac_media_info');

        $rootNode
            ->children()
                ->scalarNode('path')->isRequired()->end()
            ->end();

        return $treeBuilder;
    }
}
