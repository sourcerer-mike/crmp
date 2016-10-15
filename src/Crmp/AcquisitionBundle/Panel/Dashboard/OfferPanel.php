<?php

namespace Crmp\AcquisitionBundle\Panel\Dashboard;

use Crmp\AcquisitionBundle\Entity\Offer;
use Crmp\CrmBundle\Twig\AbstractPanel;
use Crmp\CrmBundle\Twig\PanelInterface;

/**
 * Dashboard panel about open offers.
 *
 * @package Crmp\AcquisitionBundle\Panel\Dashboard
 */
class OfferPanel extends AbstractPanel implements PanelInterface
{
    /**
     * Gather undetermined offers.
     *
     * @return array
     */
    public function getData()
    {
        if ($this->data) {
            return $this->data;
        }

        $repository = $this->container->get('doctrine.orm.entity_manager')
                                      ->getRepository('CrmpAcquisitionBundle:Offer');

        $offers = $repository->findBy(
            [
                'status' => 0, // Offers without any state are undetermined.
            ],
            null,
            3
        );

        return [
            'offers' => $offers,
        ];
    }

    /**
     * Not visible when no open offer is found.
     *
     * @return bool
     */
    public function isVisible()
    {
        $data = $this->getData();

        return (bool) $data['offers'];
    }


    /**
     * Return a unique identifier among all known boardlets.
     *
     * @return string
     */
    public function getId()
    {
        return 'dashboard_offer';
    }

    /**
     * Override default template.
     *
     * @return string
     */
    public function getTemplate()
    {
        return 'CrmpAcquisitionBundle:Offer:_panel-dashboard.html.twig';
    }

    /**
     * Return the name of this panel.
     *
     * @return string
     */
    public function getTitle()
    {
        return $this->container->get('translator')->trans('crmp_acquisition.offer.open');
    }
}
