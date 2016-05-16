<?php

namespace Crmp\CrmBundle;

use Crmp\CrmBundle\DependencyInjection\Compiler\PanelsPass;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;

class CrmBundle extends Bundle
{
    public function build(ContainerBuilder $container)
    {
        parent::build($container);

        $container->addCompilerPass(new PanelsPass());
    }

}
