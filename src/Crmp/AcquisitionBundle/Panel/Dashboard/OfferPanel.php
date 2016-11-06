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
     * @return \ArrayObject
     */
    public function getData()
    {
        if (isset($this->data['offers'])) {
            // seems like already fetched before => reuse cached data
            return $this->data;
        }

        $this->data['offers'] = [];

        $offer = new Offer();
        $offer->setStatus(0);

        $this->data['offers'] = $this->repository->findAllSimilar($offer, 3);

        return $this->data;
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
        // override your mama
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
}
