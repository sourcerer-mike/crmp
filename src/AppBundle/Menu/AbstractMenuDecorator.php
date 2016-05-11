<?php

namespace AppBundle\Menu;


use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\RequestStack;

abstract class AbstractMenuDecorator implements MenuDecoratorInterface
{
    /**
     * @var ContainerInterface
     */
    protected $container;

    /**
     * @var MenuBuilder
     */
    protected $menuBuilder;

    /**
     * MenuBuilder constructor.
     *
     * @param MenuInterface      $menu The menu to decorate.
     * @param ContainerInterface $container
     */
    public function __construct(MenuInterface $menu, ContainerInterface $container)
    {
        $this->menuBuilder = $menu;
        $this->container   = $container;
    }

    public function createMainMenu(RequestStack $requestStack)
    {
        return $this->menuBuilder->createMainMenu($requestStack);
    }

    public function createRelatedMenu(RequestStack $requestStack)
    {
        return $this->menuBuilder->createRelatedMenu($requestStack);
    }
}