<?php

namespace SHelper\MediaBundle\DependencyInjection;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\DefinitionDecorator;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\DependencyInjection\Loader;

/**
 * This is the class that loads and manages your bundle configuration
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/extension.html}
 */
class SHelperMediaExtension extends Extension
{
    /**
     * {@inheritdoc}
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $configs);

        $loader = new Loader\YamlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
        $loader->load('services.yml');

        $defaultResolution = [
            'width' => 200,
            'height' => 200,
        ];

        if (!isset($config['original_resolution'])) {
            $config['original_resolution'] = $defaultResolution;
        } else {
            $config['original_resolution'] = array_merge($defaultResolution, $config['original_resolution']);
        }

        foreach ($config['previews'] as &$preview) {
            $preview = array_merge($defaultResolution, $preview);
        }

        $definition = new DefinitionDecorator('shelper_media.data.abstract_image_service');
        $definition->addArgument($config);

//        $container->setDefinition('shelper_media.data.image_service', $definition);
//        $container->setDefinition('shelper_media.data.image_service_config', $definition);
        $container->setParameter('shelper_media.data.image_service_config', $config);
    }
}
