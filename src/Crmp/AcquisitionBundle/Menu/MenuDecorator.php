<?php

namespace Crmp\AcquisitionBundle\Menu;

use AppBundle\Menu\AbstractMenuDecorator;
use Crmp\AcquisitionBundle\Entity\Contract;
use Crmp\AcquisitionBundle\Entity\Inquiry;
use Crmp\AcquisitionBundle\Entity\Offer;
use Crmp\CrmBundle\CoreDomain\Config\ConfigRepository;
use Crmp\CrmBundle\Entity\Customer;
use Knp\Menu\MenuItem;
use Symfony\Component\HttpFoundation\RequestStack;

/**
 * Class MenuDecorator
 *
 * @package Crmp\AcquisitionBundle\Menu
 *
 * @deprecated 2.0.0 This should be replaced with a more modular/simpler kind of class (SinglePurpose).
 */
class MenuDecorator extends AbstractMenuDecorator
{
    /**
     * Add context menu when viewing a list of inquiries.
     *
     * Related actions:
     *
     * - Create new inquiry.
     *
     * @param MenuItem $menuItem
     */
    public function buildAcquisitionInquiryIndexRelatedMenu(MenuItem $menuItem)
    {
        $menuItem->addChild(
            'crmp_acquisition.inquiry.new',
            [
                'route'           => 'crmp_acquisition_inquiry_new',
                'labelAttributes' => [
                    'icon' => 'fa fa-plus',
                ],
            ]
        );
    }

    /**
     * Add context menu when viewing an inquiry.
     *
     * Related actions:
     *
     * - Edit current inquiry.
     * - Create offer based on current inquiry.
     *
     * @param MenuItem $menuItem
     */
    public function buildAcquisitionInquiryShowRelatedMenu(MenuItem $menuItem)
    {
        $params = $this->container->get('crmp.controller.render.parameters');

        if (isset($params['inquiry']) && $params['inquiry'] instanceof Inquiry) {
            $menuItem->addChild(
                'crmp_acquisition.inquiry.edit',
                [
                    'route'           => 'crmp_acquisition_inquiry_edit',
                    'routeParameters' => [
                        'id' => $params['inquiry']->getId(),
                    ],
                    'labelAttributes' => [
                        'icon' => 'fa fa-edit',
                    ],
                ]
            );

            $menuItem->addChild(
                'crmp_acquisition.offer.new',
                [
                    'route'           => 'crmp_acquisition_offer_new',
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

    /**
     * Add context menu when viewing a list of contracts.
     *
     * Related actions:
     *
     * - Create new contract.
     *
     * @param MenuItem $menuItem
     */
    public function buildAcquisitionContractIndexRelatedMenu(MenuItem $menuItem)
    {
        $menuItem->addChild(
            'crmp_acquisition.contract.new',
            [
                'route'           => 'crmp_acquisition_contract_new',
                'labelAttributes' => [
                    'icon' => 'fa fa-plus',
                ],
            ]
        );
    }

    /**
     * Add context menu when viewing a contract.
     *
     * Related actions:
     *
     * - Edit current contract.
     *
     * @param MenuItem $menuItem
     */
    public function buildAcquisitionContractShowRelatedMenu(MenuItem $menuItem)
    {
        $params = $this->container->get('crmp.controller.render.parameters');

        if (isset($params['contract']) && $params['contract'] instanceof Contract) {
            /** @var Contract $contract */
            $contract = $params['contract'];

            $menuItem->addChild(
                'crmp_acquisition.contract.edit',
                [
                    'route'           => 'crmp_acquisition_contract_edit',
                    'routeParameters' => [
                        'id' => $contract->getId(),
                    ],
                    'labelAttributes' => [
                        'icon' => 'fa fa-edit',
                    ],
                ]
            );
        }
    }

    /**
     * Add context menu when viewing a list of offers.
     *
     * Related actions:
     *
     * - Create new offer.
     *
     * @param MenuItem $menuItem
     */
    public function buildAcquisitionOfferIndexRelatedMenu(MenuItem $menuItem)
    {
        $menuItem->addChild(
            'crmp_acquisition.offer.new',
            [
                'route'           => 'crmp_acquisition_offer_new',
                'labelAttributes' => [
                    'icon' => 'fa fa-plus',
                ],
            ]
        );
    }

    /**
     * Add context menu when viewing a single offer.
     *
     * Related actions:
     *
     * - Edit current offer.
     * - Create contract based on offer.
     *
     * @param MenuItem $menuItem
     */
    public function buildAcquisitionOfferShowRelatedMenu(MenuItem $menuItem)
    {
        $params = $this->container->get('crmp.controller.render.parameters');

        if (! isset($params['offer']) || false == $params['offer'] instanceof Offer) {
            // no offer set or not an offer => incorrect context
            return;
        }

        /** @var Offer $offer */
        $offer = $params['offer'];

        $menuItem->addChild(
            'crmp_acquisition.offer.edit',
            [
                'route'           => 'crmp_acquisition_offer_edit',
                'routeParameters' => [
                    'id' => $offer->getId(),
                ],
                'labelAttributes' => [
                    'icon' => 'fa fa-edit',
                ],
            ]
        );

        $menuItem->addChild(
            'crmp_acquisition.contract.new',
            [
                'route'           => 'crmp_acquisition_contract_new',
                'routeParameters' => [
                    'offer' => $offer->getId(),
                ],
                'labelAttributes' => [
                    'icon' => 'fa fa-plus',
                ],
            ]
        );

        /** @var ConfigRepository $config */
        $config = $this->container->get('crmp_acquisition.config');

        // Status buttons
        $configValue = (array) $config->get('crmp_acquisition.offer.states');

        foreach ($configValue as $label => $stateId) {
            if ($offer->getStatus() == $stateId) {
                // This is the current state => do not show as an option
                continue;
            }

            $menuItem->addChild(
                $label,
                [
                    'route'           => 'crmp_acquisition_offer_put',
                    'routeParameters' => [
                        'id'  => $offer->getId(),
                        'status' => $stateId,
                    ],
                    'labelAttributes' => [
                        'icon' => 'fa fa-tag',
                    ],
                ]
            );
        }
    }

    /**
     * Add context menu when viewing a single customer.
     *
     * Related actions:
     *
     * - Create inquiry.
     *
     * @param MenuItem $menuItem
     */
    public function buildCrmCustomerShowRelatedMenu(MenuItem $menuItem)
    {
        $params = $this->container->get('crmp.controller.render.parameters');

        if (isset($params['customer']) && $params['customer'] instanceof Customer) {
            $menuItem->addChild(
                'crmp_acquisition.inquiry.new',
                [
                    'route'           => 'crmp_acquisition_inquiry_new',
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
     * Add menu entries for acquisition.
     *
     * Adds acquisition menu:
     *
     * - Contract
     * - Inquiry
     * - Offer
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

        $acquisition = $menu->addChild('crmp_acquisition.menu.label');

        $acquisition->addChild('crmp_acquisition.menu.inquiry', ['route' => 'crmp_acquisition_inquiry_index']);
        $acquisition->addChild('crmp_acquisition.menu.offer', ['route' => 'crmp_acquisition_offer_index']);
        $acquisition->addChild('crmp_acquisition.menu.contract', ['route' => 'crmp_acquisition_contract_index']);

        return $menu;
    }
}
