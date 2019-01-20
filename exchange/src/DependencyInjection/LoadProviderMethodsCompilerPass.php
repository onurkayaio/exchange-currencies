<?php

namespace App\DependencyInjection;

use App\Enum\ExchangeProviderEnum;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;

class LoadProviderMethodsCompilerPass implements CompilerPassInterface
{
    public function process(ContainerBuilder $container)
    {
        /**
         * make a new compiler pass object to get all the provider adapters into context object.
         * we get provider services by tag that we configured in services.yml,
         * and define a function name to get services when call defined function.
         */
        $context = $container->findDefinition(ExchangeProviderEnum::PROVIDER_CONTEXT_ID);

        $taggedServices = $container->findTaggedServiceIds(ExchangeProviderEnum::PROVIDER_SERVICE_ID);

        foreach (array_keys($taggedServices) as $taggedServiceId) {
            $context->addMethodCall(ExchangeProviderEnum::PROVIDER_METHOD, [new Reference($taggedServiceId)]);
        }
    }
}