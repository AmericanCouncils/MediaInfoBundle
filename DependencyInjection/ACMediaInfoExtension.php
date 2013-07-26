<?php

namespace AC\MediaInfoBundle\DependencyInjection;

use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;
use Symfony\Component\Config\FileLocator;

class ACMediaInfoExtension extends Extension
{
    public function load(array $configs, ContainerBuilder $container)
    {
        //load services
        $loader = new YamlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
        $loader->load('services.yml');
        
        //set configs
        $config = $this->processConfiguration(new Configuration(), $configs);
        foreach ($config as $key => $val) {
            $container->setParameter('ac_media_info.'.$key, $val);
        }
    }
}
