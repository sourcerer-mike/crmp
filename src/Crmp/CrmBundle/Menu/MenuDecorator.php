<?php

namespace Crmp\CrmBundle\Menu;


use AppBundle\Menu\AbstractMenuDecorator;
use Knp\Menu\MenuItem;
use Symfony\Component\HttpFoundation\RequestStack;

class MenuDecorator extends AbstractMenuDecorator
{
    public function buildAddressIndexRelatedMenu(MenuItem $menuItem)
    {
        $menuItem->addChild(
            'crmp.crm.address.create',
            [
                'route'           => 'address_new',
                'labelAttributes' => [
                    'icon' => 'fa fa-plus',
                ],
            ]
        );
    }

    public function buildAddressNewRelatedMenu(MenuItem $menuItem)
    {
        $abortParams = [
            'route'           => 'address_index',
            'labelAttributes' => [
                'icon' => 'fa fa-ban',
            ],
        ];

        if ($abortParams) {
            $menuItem->addChild('crmp.abort', $abortParams);
        }
    }

    public function createMainMenu(RequestStack $requestStack)
    {
        $menu = parent::createMainMenu($requestStack);

        $crm = $menu->addChild('CRM');

        $crm->addChild('Address', ['route' => 'address_index']);
        $crm->addChild('Customer', ['route' => 'customer_index']);

        return $menu;
    }

}