<?php

namespace Crmp\CrmBundle\Menu;

use Knp\Menu\FactoryInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Interface for a menu builder.
 *
 * @package AppBundle\Menu
 */
interface MenuBuilderInterface extends MenuInterface
{
    /**
     * MenuBuilderInterface constructor.
     *
     * @param FactoryInterface   $factory
     * @param ContainerInterface $serviceContainer
     */
    public function __construct(FactoryInterface $factory, ContainerInterface $serviceContainer);
}
