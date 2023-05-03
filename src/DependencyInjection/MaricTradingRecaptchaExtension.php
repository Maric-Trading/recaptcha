<?php

namespace MaricTrading\Recaptcha\DependencyInjection;

use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Extension\PrependExtensionInterface;
use Symfony\Component\DependencyInjection\Loader;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;

class MaricTradingRecaptchaExtension extends Extension implements PrependExtensionInterface
{

    public function load(array $configs, ContainerBuilder $container): void
    {
        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration,$configs);

        $container->setParameter('maric_trading.recaptcha.google_recpatcha_site_key', $config['GOOGLE_RECAPTCHA_SITE_KEY']);
        $container->setParameter('maric_trading.recaptcha.google_recpatcha_secret_key', $config['GOOGLE_RECAPTCHA_SECRET_KEY']);

        $loader = new Loader\YamlFileLoader($container, new FileLocator(__DIR__.'/../../config'));
        $loader->load("services.yaml");
    }

    public function getAlias(): string
    {
        return 'maric_trading_recaptcha';
    }

    public function prepend(ContainerBuilder $container): void
    {
        $container->prependExtensionConfig('twig', [
            'form_themes' => [
                //__DIR__."/../../templates/form/recaptcha_type.html.twig", // "templates/form/recaptcha_type.html.twig
                '@MaricTradingRecaptcha/form/recaptcha_type.html.twig'
            ]
        ]);
    }
}