<?php

namespace Crmp\CrmBundle\Twig;


use Symfony\Component\DependencyInjection\ContainerInterface;

class RegisterGlobals extends \Twig_Extension implements \Twig_Extension_GlobalsInterface
{
    /**
     * @var ContainerInterface The service container to register as global variable.
     */
    protected $container;

    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    public function getGlobals()
    {
        return [
            'crmp_crm' => [
                'container' => $this->container,
            ],
        ];
    }

    public function getName()
    {
        return 'crmp_crm.twig.register_globals';
    }
}