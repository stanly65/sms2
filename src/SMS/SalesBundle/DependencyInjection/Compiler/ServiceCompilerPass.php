<?php

namespace SMS\SalesBundle\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Definition;

class ServiceCompilerPass implements CompilerPassInterface
{
    /**
     * Adds services with a given tag.
     *
     * @param ContainerBuilder $container
     */
    public function process(ContainerBuilder $container)
    {
        $container->getDefinition('sms_sales.shipment')
            ->addArgument(
                array_keys($container->findTaggedServiceIds('shipment_method'))
            );
        $container->getDefinition('sms_sales.payment')
            ->addArgument(
                array_keys($container->findTaggedServiceIds('payment_method'))
            );
    }
}
