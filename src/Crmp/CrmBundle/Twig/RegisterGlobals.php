<?php

namespace Crmp\CrmBundle\Twig;

use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Register global variables for twig.
 *
 * @package Crmp\CrmBundle\Twig
 */
class RegisterGlobals extends \Twig_Extension implements \Twig_Extension_GlobalsInterface
{
    /**
     * @var ContainerInterface The service container to register as global variable.
     */
    protected $container;

    /**
     * RegisterGlobals constructor to inject object pool.
     *
     * @param ContainerInterface $container
     */
    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    /**
     * Build global variables for TWIG.
     *
     * Twig will contain:
     *
     * - "crmp_crmp.container" which contains the DI container
     *
     * @return array
     */
    public function getGlobals()
    {
        return [
            'crmp_crm' => [
                'container' => $this->container,
            ],
        ];
    }

    /**
     * Unique name for this Twig-Extension.
     *
     * @return string
     */
    public function getName()
    {
        return 'crmp_crm.twig.register_globals';
    }
}
