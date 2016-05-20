<?php

namespace Crmp\CrmBundle\Twig;


use Symfony\Component\DependencyInjection\ContainerInterface;
use Twig_Extension_GlobalsInterface;

class RegisterGlobals extends \Twig_Extension implements Twig_Extension_GlobalsInterface
{
    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    public function getName()
    {
        return 'crmp_crm.twig.register_globals';
    }

    public function getGlobals()
    {
        return [
            'container' => $this->container,
        ];
    }


}