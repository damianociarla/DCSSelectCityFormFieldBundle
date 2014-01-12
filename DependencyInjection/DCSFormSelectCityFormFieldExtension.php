<?php

namespace DCS\Form\SelectCityFormFieldBundle\DependencyInjection;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\DependencyInjection\Loader;

class DCSFormSelectCityFormFieldExtension extends Extension
{
    /**
     * {@inheritDoc}
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $configs);

        $loader = new Loader\XmlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));

        if (!in_array(strtolower($config['db_driver']), array('orm'))) {
            throw new \InvalidArgumentException(sprintf('Invalid db driver "%s".', $config['db_driver']));
        }

        $loader->load(sprintf('%s.xml', $config['db_driver']));

        $container->setParameter('dcs_select_city_form_field.model.country.class', $config['model']['country']);
        $container->setParameter('dcs_select_city_form_field.model.region.class', $config['model']['region']);
        $container->setParameter('dcs_select_city_form_field.model.city.class', $config['model']['city']);

        $container->setAlias('dcs_select_city_form_field.manager.country', $config['service']['manager']['country']);
        $container->setAlias('dcs_select_city_form_field.manager.region', $config['service']['manager']['region']);
        $container->setAlias('dcs_select_city_form_field.manager.city', $config['service']['manager']['city']);

        $container->setParameter('dcs_select_city_form_field.api_security', $config['api_security']);

        $loader->load('form.xml');
    }
}
