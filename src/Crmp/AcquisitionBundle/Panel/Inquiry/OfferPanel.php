<?php

namespace Crmp\AcquisitionBundle\Panel\Inquiry;

use Crmp\AcquisitionBundle\Entity\Inquiry;
use Crmp\AcquisitionBundle\Entity\Offer;
use Crmp\CrmBundle\Twig\AbstractPanel;
use Crmp\CrmBundle\Twig\PanelInterface;

/**
 * List all inquiries in single offer view.
 *
 * @package Crmp\AcquisitionBundle\Panel\Inquiry
 */
class OfferPanel extends AbstractPanel implements PanelInterface
{
    /**
     * Gather inquiries for current offer.
     *
     * @return array
     */
    public function getData()
    {
        if (isset($this->data['offers'])) {
            // seems like already fetched before => reuse cached data
            return $this->data->getArrayCopy();
        }

        $this->data['offers'] = [];

        if (! isset($this->data['inquiry']) || false == ($this->data['inquiry'] instanceof Inquiry)) {
            return $this->data->getArrayCopy();
        }

        $offer = new Offer();
        $offer->setInquiry($this->data['inquiry']);

        $this->data['offers'] = $this->repository->findAllSimilar($offer);

        return $this->data->getArrayCopy();
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
     * Override the default template for panels.
     *
     * @return string
     */
    public function getTemplate()
    {
        return 'CrmpAcquisitionBundle:Inquiry:_panel-offer.html.twig';
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
