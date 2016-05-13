<?php

namespace Crmp\AcquisitionBundle\Menu;


use AppBundle\Menu\AbstractMenuDecorator;
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