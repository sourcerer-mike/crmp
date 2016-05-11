<?php

namespace AppBundle\Menu;


use Symfony\Component\DependencyInjection\ContainerInterface;

abstract class AbstractMenuDecorator
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
     * @param MenuBuilder $menu The menu to decorate.
     *
     */
    public function __construct(MenuBuilder $menu, $container)
    {
        $this->menuBuilder = $menu;
        $this->container   = $container;
    }

    public function __call($method, $arguments)
    {
        return call_user_func_array([$this->menuBuilder, $method], $arguments);
    }
}