<?php

namespace AppBundle\Menu;

use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Interface for other bundles to enhance a menu tree.
 *
 * @see     AbstractMenuDecorator
 *
 * @package AppBundle\Menu
 */
interface MenuDecoratorInterface extends MenuInterface
{
    /**
     * MenuDecoratorInterface constructor.
     *
     * @param MenuInterface      $menu
     * @param ContainerInterface $container
     */
    public function __construct(MenuInterface $menu, ContainerInterface $container);
}
