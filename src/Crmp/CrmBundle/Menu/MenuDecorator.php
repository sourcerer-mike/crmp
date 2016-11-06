<?php

namespace Crmp\CrmBundle\Menu;

use Crmp\CrmBundle\Menu\AbstractMenuDecorator;
use Crmp\CrmBundle\Entity\Address;
use Crmp\CrmBundle\Entity\Customer;
use Knp\Menu\MenuItem;
use Symfony\Component\HttpFoundation\RequestStack;

/**
 * Enhance main and context menus for CRM.
 *
 * @package Crmp\CrmBundle\Menu
 */
class MenuDecorator extends AbstractMenuDecorator
{
    /**
     * Add context menu while looking at a list of addresses.
     *
     * Related actions:
     *
     * - Create new address.
     *
     * @param MenuItem $menuItem
     */
    public function buildCrmAddressIndexRelatedMenu(MenuItem $menuItem)
    {
        $menuItem->addChild(
            'crmp_crm.address.create',
            [
                'route'           => 'crmp_crm_address_new',
                'labelAttributes' => [
                    'icon' => 'fa fa-plus',
                ],
            ]
        );
    }

    /**
     * Add context menu while creating a new address.
     *
     * Related actions:
     *
     * - Abort creating an address.
     *
     * @param MenuItem $menuItem
     */
    public function buildCrmAddressNewRelatedMenu(MenuItem $menuItem)
    {
        $abortParams = [
            'route'           => 'crmp_crm_address_index',
            'labelAttributes' => [
                'icon' => 'fa fa-ban',
            ],
        ];

        if ($abortParams) {
            $menuItem->addChild('crmp.abort', $abortParams);
        }
    }

    /**
     * Add context menu while looking at a single address.
     *
     * Related actions:
     *
     * - Edit address.
     *
     * @param MenuItem $menuItem
     */
    public function buildCrmAddressShowRelatedMenu(MenuItem $menuItem)
    {
        $params = $this->getRenderParams();

        if (isset($params['address']) && $params['address'] instanceof Address) {
            $menuItem->addChild(
                'crmp_crm.address.edit',
                [
                    'route'           => 'crmp_crm_address_edit',
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

    /**
     * Add context menu in the list of customers.
     *
     * Related actions:
     *
     * - Create new customer.
     *
     * @param MenuItem $menuItem
     */
    public function buildCrmCustomerIndexRelatedMenu(MenuItem $menuItem)
    {
        $menuItem->addChild(
            'crmp_crm.customer.create',
            [
                'route'           => 'crmp_crm_customer_new',
                'labelAttributes' => [
                    'icon' => 'fa fa-plus',
                ],
            ]
        );
    }

    /**
     * Add context menu while looking at a customer.
     *
     * Related actions:
     *
     * - Edit customer.
     * - Add address for current customer.
     *
     * @param MenuItem $menuItem
     */
    public function buildCrmCustomerShowRelatedMenu(MenuItem $menuItem)
    {
        $params = $this->getRenderParams();

        if (isset($params['customer']) && $params['customer'] instanceof Customer) {
            $menuItem->addChild(
                'crmp_crm.customer.edit',
                [
                    'route'           => 'crmp_crm_customer_edit',
                    'routeParameters' => [
                        'id' => $params['customer']->getId(),
                    ],
                    'labelAttributes' => [
                        'icon' => 'fa fa-edit',
                    ],
                ]
            );

            $menuItem->addChild(
                'crmp_crm.address.create',
                [
                    'route'           => 'crmp_crm_address_new',
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

    /**
     * Add context menu while creating a customer.
     *
     * Related actions:
     *
     * - Abort
     *
     * @param MenuItem $menuItem
     */
    public function buildCrmCustomerNewRelatedMenu(MenuItem $menuItem)
    {
        $abortParams = [
            'route'           => 'crmp_crm_customer_index',
            'labelAttributes' => [
                'icon' => 'fa fa-ban',
            ],
        ];

        if ($abortParams) {
            $menuItem->addChild('crmp.abort', $abortParams);
        }
    }

    /**
     * Add main menu entries.
     *
     * Entries will be:
     *
     * - CRM
     *   - Addresses
     *   - Customers
     *
     * @param RequestStack $requestStack
     *
     * @return \Knp\Menu\ItemInterface
     */
    public function createMainMenu(RequestStack $requestStack)
    {
        $menu = parent::createMainMenu($requestStack);

        $user = $this->getUser();

        if ('anon.' == $user) {
            // not logged in, skip
            return $menu;
        }

        $crm = $menu->addChild('crmp_crm.singular');

        $crm->addChild('crmp_crm.address.plural', ['route' => 'crmp_crm_address_index']);
        $crm->addChild('crmp_crm.customer.plural', ['route' => 'crmp_crm_customer_index']);

        return $menu;
    }
}
