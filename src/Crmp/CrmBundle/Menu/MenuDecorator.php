<?php

namespace Crmp\CrmBundle\Menu;


use AppBundle\Menu\AbstractMenuDecorator;
use Symfony\Component\HttpFoundation\RequestStack;

class MenuDecorator extends AbstractMenuDecorator
{
    public function createMainMenu(RequestStack $requestStack)
    {
        $menu = parent::createMainMenu($requestStack);

        $crm = $menu->addChild('CRM');

        $crm->addChild('Address', ['route' => 'address_index']);
        $crm->addChild('Customer', ['route' => 'customer_index']);

        return $menu;
    }

}