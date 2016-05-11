<?php

namespace Crmp\AcquisitionBundle\Menu;


use AppBundle\Menu\AbstractMenuDecorator;
use Symfony\Component\HttpFoundation\RequestStack;

class MenuDecorator extends AbstractMenuDecorator
{
    public function createMainMenu(RequestStack $requestStack)
    {
        $menu = parent::createMainMenu($requestStack);

        $acquisition = $menu->addChild('crmp.acquisition.menu');

        $acquisition->addChild('crmp.acquisition.menu.inquiry', ['route' => 'inquiry_index']);
        $acquisition->addChild('crmp.acquisition.menu.offer', ['route' => 'offer_index']);
        $acquisition->addChild('crmp.acquisition.menu.contract', ['route' => 'contract_index']);

        return $menu;
    }

}