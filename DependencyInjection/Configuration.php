<?php

namespace DCS\Form\SelectCityFormFieldBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

class Configuration implements ConfigurationInterface
{
    /**
     * {@inheritDoc}
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('dcs_form_select_city_form_field');

        $rootNode
            ->children()
                ->scalarNode('api_security')
                    ->defaultValue('IS_AUTHENTICATED_ANONYMOUSLY')
                ->end()
            ->end()
        ;

        return $treeBuilder;
    }
}
