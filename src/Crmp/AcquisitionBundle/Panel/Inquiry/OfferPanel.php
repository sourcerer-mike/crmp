<?php

namespace Crmp\AcquisitionBundle\Panel\Inquiry;


use Crmp\AcquisitionBundle\Entity\Inquiry;
use Crmp\CrmBundle\Twig\AbstractPanel;
use Crmp\CrmBundle\Twig\PanelInterface;

class OfferPanel extends AbstractPanel implements PanelInterface
{
    public function getData()
    {
        if ($this->data) {
            return (array) $this->data;
        }

        $this->data           = $this->container->get('crmp.controller.render.parameters');
        $this->data['offers'] = [];

        if ( ! isset( $this->data['inquiry'] ) || false == ( $this->data['inquiry'] instanceof Inquiry )) {
            return $this->data;
        }

        /** @var Inquiry $inquiry */
        $inquiry    = $this->data['inquiry'];
        $addressRepo = $this->container->get('doctrine')->getRepository('CrmpAcquisitionBundle:Offer');

        $this->data['offers'] = $addressRepo->findBy(
            [
                'inquiry' => $inquiry,
            ],
            null,
            10
        );

        return $this->data;
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