<?php

namespace Crmp\CrmBundle\Menu;


use AppBundle\Menu\AbstractMenuDecorator;
use Crmp\CrmBundle\Entity\Address;
use Crmp\CrmBundle\Entity\Customer;
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

    public function buildCustomerIndexRelatedMenu(MenuItem $menuItem)
    {
        $menuItem->addChild(
            'crmp.crm.customer.create',
            [
                'route'           => 'customer_new',
                'labelAttributes' => [
                    'icon' => 'fa fa-plus',
                ],
            ]
        );
    }

    public function buildCustomerShowRelatedMenu(MenuItem $menuItem)
    {
        $params = $this->container->get('crmp.controller.render.parameters');

        if (isset($params['customer']) && $params['customer'] instanceof Customer)
        {
            $menuItem->addChild(
                'crmp.crm.customer.edit',
                [
                    'route'           => 'customer_edit',
                    'routeParameters' => [
                        'id' => $params['customer']->getId(),
                    ],
                    'labelAttributes' => [
                        'icon' => 'fa fa-edit',
                    ],
                ]
            );

            $menuItem->addChild(
                'crmp.crm.address.create',
                [
                    'route'           => 'address_new',
                    'routeParameters' => [
                        'customer' => $params['customer']->getId(),
                    ],
                    'labelAttributes' => [
                        'icon' => 'fa fa-plus',
                    ],
                ]
            );
        }
    }

    public function buildCustomerNewRelatedMenu(MenuItem $menuItem)
    {
        $abortParams = [
            'route'           => 'customer_index',
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

        $user = $this->container->get('security.token_storage')->getToken()->getUser();

        if ('anon.' == $user) {
            // not logged in, skip
            return $menu;
        }

        $crm = $menu->addChild('CRM');

        $crm->addChild('crmp.crm.address.plural', ['route' => 'address_index']);
        $crm->addChild('crmp.crm.customer.plural', ['route' => 'customer_index']);

        return $menu;
    }

}