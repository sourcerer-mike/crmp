<?php

namespace Crmp\CrmBundle;

use Crmp\CrmBundle\DependencyInjection\Compiler\PanelsPass;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;

/**
 * CRM features for CRMP.
 *
 * @package Crmp\CrmBundle
 */
class CrmpCrmBundle extends Bundle
{
    /**
     * Modify the container builder.
     *
     * The container builder will be enhanced by:
     *
     * - The PanelsPass to allow registering (related) panels.
     *
     * @see PanelsPass
     *
     * @param ContainerBuilder $container
     */
    public function build(ContainerBuilder $container)
    {
        parent::build($container);

        $container->addCompilerPass(new PanelsPass());
    }
}
