<?php

namespace Crmp\AcquisitionBundle\Panel\Customer;


use Crmp\CrmBundle\Entity\Customer;
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

        if ( ! isset( $this->data['customer'] ) || false == ( $this->data['customer'] instanceof Customer )) {
            return $this->data;
        }

        /** @var Customer $customer */
        $customer    = $this->data['customer'];
        $addressRepo = $this->container->get('doctrine')->getRepository('CrmpAcquisitionBundle:Contract');

        $this->data['contracts'] = $addressRepo->findBy(
            [
                'customer' => $customer,
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
        return 'CrmpAcquisitionBundle:Customer:_panel-contract.html.twig';
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