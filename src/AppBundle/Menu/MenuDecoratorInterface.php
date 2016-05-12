<?php

namespace AppBundle\Menu;


use Symfony\Component\DependencyInjection\ContainerInterface;

interface MenuDecoratorInterface extends MenuInterface
{
    public function __construct(MenuInterface $menu, ContainerInterface $container);
}