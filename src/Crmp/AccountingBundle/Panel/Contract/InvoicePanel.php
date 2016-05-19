<?php

namespace Crmp\AccountingBundle\Panel\Contract;


use Crmp\AcquisitionBundle\Entity\Contract;
use Crmp\CrmBundle\Entity\Customer;
use Crmp\CrmBundle\Twig\AbstractPanel;
use Crmp\CrmBundle\Twig\PanelInterface;

class InvoicePanel extends AbstractPanel implements PanelInterface
{
    public function getData()
    {
        if ($this->data) {
            return (array) $this->data;
        }

        $this->data             = $this->container->get('crmp.controller.render.parameters');
        $this->data['invoices'] = [];

        if ( ! isset( $this->data['contract'] ) || false == ( $this->data['contract'] instanceof Contract )) {
            return $this->data;
        }

        /** @var Contract $contract */
        $contract    = $this->data['contract'];
        $addressRepo = $this->container->get('doctrine')->getRepository('CrmpAccBundle:Invoice');

        $this->data['invoices'] = $addressRepo->findBy(
            [
                'contract' => $contract,
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
        return 'crmp.contract.panel.invoices';
    }

    public function getTemplate()
    {
        return 'CrmpAccBundle:Contract:_panel-invoice.html.twig';
    }

    /**
     * Return the name of this panel.
     *
     * @return string
     */
    public function getTitle()
    {
        return $this->container->get('translator')->trans('crmp.accounting.invoice.plural');
    }


}