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
                ->scalarNode('db_driver')->isRequired()->end()
                ->scalarNode('api_security')
                    ->defaultValue('IS_AUTHENTICATED_ANONYMOUSLY')
                ->end()
            ->end()
            ->append($this->buildModelConfiguration())
            ->append($this->buildServiceConfiguration())
        ;

        return $treeBuilder;
    }

    private function buildModelConfiguration()
    {
        $builder = new TreeBuilder();
        $node = $builder->root('model');

        $node
            ->isRequired()
            ->children()
                ->scalarNode('country')
                    ->isRequired()
                    ->cannotBeEmpty()
                ->end()
                ->scalarNode('region')
                    ->isRequired()
                    ->cannotBeEmpty()
                ->end()
                ->scalarNode('city')
                    ->isRequired()
                    ->cannotBeEmpty()
                ->end()
            ->end()
        ;

        return $node;
    }

    private function buildServiceConfiguration()
    {
        $builder = new TreeBuilder();
        $node = $builder->root('service');

        $node
            ->addDefaultsIfNotSet()
            ->children()
                ->arrayNode('manager')->addDefaultsIfNotSet()
                    ->children()
                        ->scalarNode('country')->cannotBeEmpty()->defaultValue('dcs_select_city_form_field.manager.country.default')->end()
                        ->scalarNode('region')->cannotBeEmpty()->defaultValue('dcs_select_city_form_field.manager.region.default')->end()
                        ->scalarNode('city')->cannotBeEmpty()->defaultValue('dcs_select_city_form_field.manager.city.default')->end()
                    ->end()
                ->end()
            ->end()
        ;

        return $node;
    }
}
