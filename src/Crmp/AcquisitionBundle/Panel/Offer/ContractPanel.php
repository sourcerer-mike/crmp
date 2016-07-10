<?php

namespace Crmp\AcquisitionBundle\Panel\Offer;

use Crmp\AcquisitionBundle\Entity\Offer;
use Crmp\CrmBundle\Twig\AbstractPanel;
use Crmp\CrmBundle\Twig\PanelInterface;

/**
 * List offers in the single contract view.
 *
 * @package Crmp\AcquisitionBundle\Panel\Offer
 */
class ContractPanel extends AbstractPanel implements PanelInterface
{
    /**
     * Gather offers for current contract.
     *
     * @return array
     */
    public function getData()
    {
        if ($this->data) {
            return (array) $this->data;
        }

        $this->data           = (array) $this->container->get('crmp.controller.render.parameters');
        $this->data['contracts'] = [];

        if (! isset($this->data['offer']) || false == ( $this->data['offer'] instanceof Offer )) {
            return (array) $this->data;
        }

        /** @var Offer $offer */
        $offer    = $this->data['offer'];
        $addressRepo = $this->container->get('doctrine')->getRepository('CrmpAcquisitionBundle:Contract');

        $this->data['contracts'] = $addressRepo->findBy(
            [
                'offer' => $offer,
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
        return 'acquisition_contract_list';
    }

    /**
     * Override default template.
     *
     * @return string
     */
    public function getTemplate()
    {
        return 'CrmpAcquisitionBundle:Offer:_panel-contract.html.twig';
    }

    /**
     * Return the name of this panel.
     *
     * @return string
     */
    public function getTitle()
    {
        return $this->container->get('translator')->trans('crmp_acquisition.contract.plural');
    }
}
