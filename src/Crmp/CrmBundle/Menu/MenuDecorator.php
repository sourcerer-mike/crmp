<?php

namespace Crmp\CrmBundle\Menu;


use AppBundle\Menu\AbstractMenuDecorator;
use Crmp\CrmBundle\Entity\Address;
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

    public function buildAddressShowRelatedMenu(MenuItem $menuItem)
    {
        $params = $this->container->get('crmp.controller.render.parameters');

        if (isset( $params['address'] ) && $params['address'] instanceof Address) {
            $menuItem->addChild(
                'crmp.edit',
                [
                    'route'           => 'address_edit',
                    'routeParameters' => [
                        'id' => $params['address']->getId(),
                    ],
                    'labelAttributes' => [
                        'icon' => 'fa fa-edit',
                    ],
                ]
            );
        }

    }

    public function createMainMenu(RequestStack $requestStack)
    {
        $menu = parent::createMainMenu($requestStack);

        $user = $this->container->get('security.token_storage')->getToken()->getUser();

        if ('anon.' == $user) {
            // not logged in, skip
            return $menu;
        }

        $crm = $menu->addChild('CRM');

        $crm->addChild('Address', ['route' => 'address_index']);
        $crm->addChild('Customer', ['route' => 'customer_index']);

        return $menu;
    }

}