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
        $menu = $this->menuBuilder->createRelatedMenu($requestStack);

        $method = ucwords($requestStack->getCurrentRequest()->get('_route'), '_');
        $method = 'build'.str_replace('_', '', $method).'RelatedMenu';

        if (method_exists($this, $method)) {
            $this->$method($menu);
        }


        return $menu;
    }

    protected function getRenderParams()
    {
        return $this->container->get('crmp.controller.render.parameters');
    }
}