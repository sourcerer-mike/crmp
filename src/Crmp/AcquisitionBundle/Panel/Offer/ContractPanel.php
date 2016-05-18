<?php

namespace Crmp\AcquisitionBundle\Panel\Offer;


use Crmp\AcquisitionBundle\Entity\Offer;
use Crmp\CrmBundle\Twig\AbstractPanel;
use Crmp\CrmBundle\Twig\PanelInterface;

class ContractPanel extends AbstractPanel implements PanelInterface
{
    public function getData()
    {
        if ($this->data) {
            return (array) $this->data;
        }

        $this->data           = $this->container->get('crmp.controller.render.parameters');
        $this->data['contracts'] = [];

        if ( ! isset( $this->data['offer'] ) || false == ( $this->data['offer'] instanceof Offer )) {
            return $this->data;
        }

        /** @var Offer $offer */
        $offer    = $this->data['offer'];
        $addressRepo = $this->container->get('doctrine')->getRepository('AcquisitionBundle:Contract');

        $this->data['contracts'] = $addressRepo->findBy(
            [
                'offer' => $offer,
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
        return 'acquisition_contract_list';
    }

    public function getTemplate()
    {
        return 'AcquisitionBundle:Offer:_panel-contract.html.twig';
    }

    /**
     * Return the name of this panel.
     *
     * @return string
     */
    public function getTitle()
    {
        return $this->container->get('translator')->trans('crmp.acquisition.contract.plural');
    }


}