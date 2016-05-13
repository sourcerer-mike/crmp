<?php

namespace Crmp\AcquisitionBundle\Menu;


use AppBundle\Menu\AbstractMenuDecorator;
use Crmp\AcquisitionBundle\Entity\Contract;
use Crmp\AcquisitionBundle\Entity\Inquiry;
use Crmp\CrmBundle\Entity\Customer;
use Knp\Menu\MenuItem;
use Symfony\Component\HttpFoundation\RequestStack;

class MenuDecorator extends AbstractMenuDecorator
{
    public function buildCustomerShowRelatedMenu(MenuItem $menuItem)
    {
        $params = $this->container->get('crmp.controller.render.parameters');

        if (isset( $params['customer'] ) && $params['customer'] instanceof Customer) {
            $menuItem->addChild(
                'crmp.acquisition.inquiry.new',
                [
                    'route'           => 'inquiry_new',
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

    public function buildInquiryIndexRelatedMenu(MenuItem $menuItem)
    {
        $menuItem->addChild(
            'crmp.acquisition.inquiry.new',
            [
                'route'           => 'inquiry_new',
                'labelAttributes' => [
                    'icon' => 'fa fa-plus',
                ],
            ]
        );
    }

    public function buildContractIndexRelatedMenu(MenuItem $menuItem)
    {
        $menuItem->addChild(
            'crmp.acquisition.contract.new',
            [
                'route'           => 'contract_new',
                'labelAttributes' => [
                    'icon' => 'fa fa-plus',
                ],
            ]
        );
    }

    public function buildContractShowRelatedMenu(MenuItem $menuItem)
    {
        $params = $this->container->get('crmp.controller.render.parameters');

        if (isset( $params['contract'] ) && $params['contract'] instanceof Contract) {
            $menuItem->addChild(
                'crmp.acquisition.contract.edit',
                [
                    'route'           => 'contract_edit',
                    'routeParameters' => [
                        'id' => $params['contract']->getId(),
                    ],
                    'labelAttributes' => [
                        'icon' => 'fa fa-edit',
                    ],
                ]
            );
        }
    }

    public function buildInquiryShowRelatedMenu(MenuItem $menuItem)
    {
        $params = $this->container->get('crmp.controller.render.parameters');

        if (isset( $params['inquiry'] ) && $params['inquiry'] instanceof Inquiry) {
            $menuItem->addChild(
                'crmp.acquisition.inquiry.edit',
                [
                    'route'           => 'inquiry_edit',
                    'routeParameters' => [
                        'id' => $params['inquiry']->getId(),
                    ],
                    'labelAttributes' => [
                        'icon' => 'fa fa-edit',
                    ],
                ]
            );

            $menuItem->addChild(
                'crmp.acquisition.offer.new',
                [
                    'route'           => 'offer_new',
                    'routeParameters' => [
                        'inquiry' => $params['inquiry']->getId(),
                    ],
                    'labelAttributes' => [
                        'icon' => 'fa fa-plus',
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

        $acquisition = $menu->addChild('crmp.acquisition.menu');

        $acquisition->addChild('crmp.acquisition.menu.inquiry', ['route' => 'inquiry_index']);
        $acquisition->addChild('crmp.acquisition.menu.offer', ['route' => 'offer_index']);
        $acquisition->addChild('crmp.acquisition.menu.contract', ['route' => 'contract_index']);

        return $menu;
    }

}