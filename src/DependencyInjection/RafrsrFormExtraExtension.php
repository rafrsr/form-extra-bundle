<?php

/**
 * LICENSE: This file is subject to the terms and conditions defined in
 * file 'LICENSE', which is part of this source code package.
 *
 * @copyright 2016 Copyright(c) - All rights reserved.
 */

namespace Rafrsr\FormExtraBundle\DependencyInjection;

use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Extension\Extension;
use Symfony\Component\DependencyInjection\Extension\PrependExtensionInterface;
use Symfony\Component\DependencyInjection\Loader;

/**
 * Read configuration
 */
class RafrsrFormExtraExtension extends Extension implements PrependExtensionInterface
{
    /**
     * {@inheritdoc}
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $configs);

        $configDir = __DIR__ . '/../Resources/config';
        $loader = new Loader\YamlFileLoader($container, new FileLocator($configDir));

        $loader->load('services.yml');

        $bundles = $container->getParameter('kernel.bundles');

        if (!isset($bundles['DoctrineBundle'])) {
            $container->removeDefinition('rafrsr_datepicker_type_guesser');
            $container->removeDefinition('rafrsr_switchery_type_guesser');
        }
    }

    /**
     * @inheritDoc
     */
    public function prepend(ContainerBuilder $container)
    {
        //automatically add required form fields
        $vendorConfig = $container->getExtensionConfig('twig')[0];

        //enabling our custom theme
        $vendorConfig['form_themes'][] = 'RafrsrFormExtraBundle::Form/fields.html.twig';
        if ($container->hasExtension('mopa_bootstrap') && isset($container->getExtensionConfig('mopa_bootstrap')[0]['form'])) {
            $vendorConfig['form_themes'][] = 'RafrsrFormExtraBundle::Form/mopa_extra_fields.html.twig';
            $container->setParameter('mopa_bootstrap_form_enabled', true);
        } else {
            $vendorConfig['form_themes'][] = 'RafrsrFormExtraBundle::Form/standalone_extra_fields.html.twig';
            $container->setParameter('mopa_bootstrap_form_enabled', false);
        }
        $container->prependExtensionConfig('twig', $vendorConfig);
    }
}
