<?php

namespace DCS\Form\SelectCityFormFieldBundle;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;
use DCS\Form\SelectCityFormFieldBundle\DependencyInjection\Compiler\TwigFormPass;

class DCSFormSelectCityFormFieldBundle extends Bundle
{
    public function build(ContainerBuilder $container)
    {
        parent::build($container);

        $container->addCompilerPass(new TwigFormPass());
    }
}
