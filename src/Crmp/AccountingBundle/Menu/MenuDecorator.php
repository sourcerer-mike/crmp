<?php

namespace Crmp\AccountingBundle\Menu;

use AppBundle\Menu\AbstractMenuDecorator;
use Crmp\AccountingBundle\Entity\Invoice;
use Crmp\AcquisitionBundle\Entity\Contract;
use Crmp\CrmBundle\Entity\Customer;
use Knp\Menu\MenuItem;
use Symfony\Component\HttpFoundation\RequestStack;

/**
 * Add menu entries for accounting.
 *
 * @package Crmp\AccountingBundle\Menu
 */
class MenuDecorator extends AbstractMenuDecorator
{
    /**
     * Add context menu while viewing a list of invoices.
     *
     * Related actions:
     *
     * - Create new invoice.
     *
     * @param MenuItem $menuItem
     */
    public function buildAccountingInvoiceIndexRelatedMenu(MenuItem $menuItem)
    {
        $menuItem->addChild(
            'crmp_accounting.invoice.new',
            [
                'route'           => 'crmp_accounting_invoice_new',
                'labelAttributes' => [
                    'icon' => 'fa fa-plus',
                ],
            ]
        );
    }

    /**
     * Add context menu while creating an invoice.
     *
     * Related actions:
     *
     * - Abort creation.
     *
     * @param MenuItem $menu
     */
    public function buildAccountingInvoiceNewRelatedMenu(MenuItem $menu)
    {
        // abort and go back to contract
        $request = $this->container->get('request_stack')->getCurrentRequest();

        $contract = $request->get('contract');

        if ($contract && is_numeric($contract)) {
            $menu->addChild(
                'crmp.abort',
                [
                    'route'           => 'crmp_acquisition_contract_show',
                    'routeParameters' => ['id' => $contract],
                    'labelAttributes' => [
                        'icon' => 'fa fa-ban',
                    ],
                ]
            );
        }
    }

    /**
     * Add context menu when viewing an invoice.
     *
     * Related actions:
     *
     * - Edit the current invoice.
     *
     * @param MenuItem $menuItem
     */
    public function buildAccountingInvoiceShowRelatedMenu(MenuItem $menuItem)
    {
        $params = $this->container->get('crmp.controller.render.parameters');

        if (isset($params['invoice']) && $params['invoice'] instanceof Invoice) {
            /** @var Invoice $invoice */
            $invoice = $params['invoice'];

            $menuItem->addChild(
                'crmp_accounting.invoice.edit',
                [
                    'route'           => 'crmp_accounting_invoice_edit',
                    'routeParameters' => [
                        'id' => $invoice->getId(),
                    ],
                    'labelAttributes' => [
                        'icon' => 'fa fa-edit',
                    ],
                ]
            );
        }
    }

    /**
     * Add context menu when looking at a single contract.
     *
     * Related actions:
     *
     * - Create invoice for contract.
     *
     * @param MenuItem $menu
     */
    public function buildAcquisitionContractShowRelatedMenu(MenuItem $menu)
    {
        $params = $this->container->get('crmp.controller.render.parameters');

        // Create invoice based on current contract
        $routeParameters = [];

        if ($params && isset($params['contract'])) {
            /** @var Contract $contract */
            $contract = $params['contract'];

            $customer = $contract->getCustomer();

            if ($customer) {
                $routeParameters['customer'] = $customer->getId();
            }

            $routeParameters['value']    = $contract->getValue();
            $routeParameters['contract'] = $contract->getId();
        }

        $menu->addChild(
            'crmp_accounting.invoice.new',
            [
                'route'           => 'crmp_accounting_invoice_new',
                'routeParameters' => $routeParameters,
                'labelAttributes' => [
                    'icon' => 'fa fa-plus',
                ],
            ]
        );
    }

    /**
     * Add context menu while looking at a single customer.
     *
     * Related actions:
     *
     * - Create invoice for current customer.
     *
     * @param MenuItem $menuItem
     */
    public function buildCrmCustomerShowRelatedMenu(MenuItem $menuItem)
    {
        $params = $this->container->get('crmp.controller.render.parameters');

        if (isset($params['customer']) && $params['customer'] instanceof Customer) {
            /** @var Customer $customer */
            $customer = $params['customer'];

            $menuItem->addChild(
                'crmp_accounting.invoice.new',
                [
                    'route'           => 'crmp_accounting_invoice_new',
                    'routeParameters' => [
                        'customer' => $customer->getId(),
                    ],
                    'labelAttributes' => [
                        'icon' => 'fa fa-plus',
                    ],
                ]
            );
        }
    }

    /**
     * Add main menu entries for accounting.
     *
     * @param RequestStack $requestStack
     *
     * @return \Knp\Menu\ItemInterface
     */
    public function createMainMenu(RequestStack $requestStack)
    {
        $menu = parent::createMainMenu($requestStack);

        $user = $this->container->get('security.token_storage')->getToken()->getUser();

        if ('anon.' == $user) {
            // not logged in, skip
            return $menu;
        }

        $acquisition = $menu->addChild('crmp_accounting.menu.label');

        $acquisition->addChild('crmp_accounting.invoice.plural', ['route' => 'crmp_accounting_invoice_index']);

        return $menu;
    }
}
