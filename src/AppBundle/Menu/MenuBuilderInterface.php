<?php

namespace AppBundle\Menu;


use Knp\Menu\FactoryInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

interface MenuBuilderInterface extends MenuInterface
{
    public function __construct(FactoryInterface $factory, ContainerInterface $serviceContainer);
}