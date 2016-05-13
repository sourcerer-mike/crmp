<?php

namespace Crmp\AccountingBundle\Menu;


use AppBundle\Menu\AbstractMenuDecorator;
use Crmp\AcquisitionBundle\Entity\Contract;
use Crmp\CrmBundle\Entity\Customer;
use Knp\Menu\MenuItem;
use Symfony\Component\HttpFoundation\RequestStack;

class MenuDecorator extends AbstractMenuDecorator
{
    public function buildContractShowRelatedMenu(MenuItem $menu)
    {
        $params = $this->container->get('crmp.controller.render.parameters');

        // Create invoice based on current contract
        $routeParameters = [];

        if ($params && isset( $params['contract'] )) {
            /** @var Contract $contract */
            $contract = $params['contract'];

            $routeParameters['customer'] = $contract->getCustomer()->getId();
            $routeParameters['value']    = $contract->getValue();
            $routeParameters['contract'] = $contract->getId();
        }

        $menu->addChild(
            'crmp.accounting.invoice.new',
            [
                'route'           => 'invoice_new',
                'routeParameters' => $routeParameters,
                'labelAttributes' => [
                    'icon' => 'fa fa-plus',
                ],
            ]
        );
    }

    public function buildCustomerShowRelatedMenu(MenuItem $menuItem)
    {
        $params = $this->container->get('crmp.controller.render.parameters');

        if (isset( $params['customer'] ) && $params['customer'] instanceof Customer) {
            $menuItem->addChild(
                'crmp.accounting.invoice.new',
                [
                    'route'           => 'invoice_new',
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

    public function buildInvoiceNewRelatedMenu(MenuItem $menu)
    {
        // abort and go back to contract
        $request = $this->container->get('request_stack')->getCurrentRequest();

        $contract = $request->get('contract');

        if ($contract && is_numeric($contract)) {
            $menu->addChild(
                'crmp.accounting.invoice.toContract',
                [
                    'route'           => 'contract_show',
                    'routeParameters' => ['id' => $contract],
                    'labelAttributes' => [
                        'icon' => 'fa fa-ban',
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

        $acquisition = $menu->addChild('Accounting');

        $acquisition->addChild('Invoice', ['route' => 'invoice_index']);

        return $menu;
    }
}