<?php

namespace Crmp\AccountingBundle\Menu;


use AppBundle\Menu\AbstractMenuDecorator;
use Symfony\Component\HttpFoundation\RequestStack;

class MenuDecorator extends AbstractMenuDecorator
{
    public function createMainMenu(RequestStack $requestStack)
    {
        $menu = parent::createMainMenu($requestStack);

        $user = $this->container->get('security.token_storage')->getToken()->getUser();

        if ('anon.' == $user) {
            // not logged in, skip
            return $menu;
        }

        $acquisition = $menu->addChild('Accounting');

        $acquisition->addChild('Invoice', ['route' => 'invoice_index']);

        return $menu;
    }
}