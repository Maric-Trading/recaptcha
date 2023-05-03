<?php

namespace MaricTrading\Recaptcha;

use MaricTrading\Recaptcha\DependencyInjection\MaricTradingRecaptchaExtension;
use Symfony\Component\Config\Definition\Configurator\DefinitionConfigurator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Extension\ExtensionInterface;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use Symfony\Component\HttpKernel\Bundle\AbstractBundle;
use Symfony\Component\HttpKernel\Bundle\Bundle;

class MaricTradingRecaptchaBundle extends AbstractBundle
{

    public function getPath(): string
    {
        return \dirname(__DIR__);
    }

    public function getContainerExtension(): ?ExtensionInterface
    {
        return new MaricTradingRecaptchaExtension();
    }

    public function configure(DefinitionConfigurator $definition): void
    {
        $definition->rootNode()
            ->children()
            ->scalarNode('GOOGLE_RECAPTCHA_SITE_KEY')->defaultValue("")->end()
            ->scalarNode('GOOGLE_RECAPTCHA_SECRET_KEY')->defaultValue("")->end()
            ->end()
            ->end();
    }

    public function loadExtension(array $config, ContainerConfigurator $containerConfigurator, ContainerBuilder $containerBuilder): void
    {
        $containerConfigurator->import('../config/services.yaml');

        $containerConfigurator->parameters()
            ->set('maric_trading.recaptcha.google_recpatcha_site_key', $config['GOOGLE_RECAPTCHA_SITE_KEY'])
            ->set('maric_trading.recaptcha.google_recpatcha_secret_key', $config['GOOGLE_RECAPTCHA_SECRET_KEY']);
    }
}
