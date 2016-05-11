<?php

namespace Crmp\AccountingBundle\Menu;


use AppBundle\Menu\AbstractMenuDecorator;
use Crmp\AcquisitionBundle\Entity\Contract;
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

    public function createRelatedMenu(RequestStack $requestStack)
    {
        $menu   = parent::createRelatedMenu($requestStack);
        $params = $this->container->get('crmp.controller.render.parameters');

        if ('contract_show' == $requestStack->getCurrentRequest()->get('_route')) {
            // Create invoice based on current contract
            $routeParameters = [];

            if ($params && isset( $params['contract'] )) {
                /** @var Contract $contract */
                $contract = $params['contract'];

                $routeParameters['customer'] = $contract->getCustomer()->getId();
                $routeParameters['value']    = $contract->getValue();
            }

            $menu->addChild(
                'crmp.accounting.invoice.create',
                [
                    'route'           => 'invoice_new',
                    'routeParameters' => $routeParameters,
                    'labelAttributes' => [
                        'icon' => 'fa fa-plus',
                    ],
                ]
            );
        }

        return $menu;
    }


}