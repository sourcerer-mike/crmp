<?php

namespace Crmp\AcquisitionBundle\Panel\Customer;

use Crmp\CrmBundle\Entity\Customer;
use Crmp\CrmBundle\Twig\AbstractPanel;
use Crmp\CrmBundle\Twig\PanelInterface;

/**
 * Show offers for a single customer.
 *
 * @package Crmp\AcquisitionBundle\Panel\Customer
 */
class OfferPanel extends AbstractPanel implements PanelInterface
{
    /**
     * Gather all offers for a single customer.
     *
     * @return array
     */
    public function getData()
    {
        if ($this->data) {
            return (array) $this->data;
        }

        $this->data           = (array) $this->container->get('crmp.controller.render.parameters');
        $this->data['offers'] = [];

        if (! isset($this->data['customer']) || false == ( $this->data['customer'] instanceof Customer )) {
            return $this->data;
        }

        /** @var Customer $customer */
        $customer    = $this->data['customer'];
        $addressRepo = $this->container->get('doctrine')->getRepository('CrmpAcquisitionBundle:Offer');

        $this->data['offers'] = $addressRepo->findBy(
            [
                'customer' => $customer,
            ],
            null,
            10
        );

        return (array) $this->data;
    }

    /**
     * Return a unique identifier among all known boardlets.
     *
     * @return string
     */
    public function getId()
    {
        return 'acquisition_offer_list';
    }

    /**
     * Override default template.
     *
     * @return string
     */
    public function getTemplate()
    {
        return 'CrmpAcquisitionBundle:Customer:_panel-offer.html.twig';
    }

    /**
     * Return the name of this panel.
     *
     * @return string
     */
    public function getTitle()
    {
        return $this->container->get('translator')->trans('crmp_acquisition.offer.plural');
    }
}
