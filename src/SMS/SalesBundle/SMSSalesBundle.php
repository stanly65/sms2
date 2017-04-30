<?php

namespace SMS\SalesBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use SMS\SalesBundle\DependencyInjection\Compiler\ServiceCompilerPass;

/**
 * Adds a compiler pass.
 *
 * @param ContainerBuilder $container
 */
class SMSSalesBundle extends Bundle
{
    public function build(ContainerBuilder $container)
    {
        parent::build($container);
        $container->addCompilerPass(new ServiceCompilerPass());
    }
}
