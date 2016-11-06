<?php

namespace Crmp\AccountingBundle\Panel\Contract;

use Crmp\AccountingBundle\Entity\Invoice;
use Crmp\AcquisitionBundle\Entity\Contract;
use Crmp\CrmBundle\Entity\Customer;
use Crmp\CrmBundle\Twig\AbstractPanel;
use Crmp\CrmBundle\Twig\PanelInterface;

/**
 * Panel about invoices while viewing a single contract.
 *
 * @package Crmp\AccountingBundle\Panel\Contract
 */
class InvoicePanel extends AbstractPanel implements PanelInterface
{
    /**
     * Gather all invoices for current contract.
     *
     * @return \ArrayObject
     */
    public function getData()
    {
        if (isset($this->data['invoices'])) {
            // Something already happend here => do not fetch another time
            return $this->data;
        }

        $this->data['invoices'] = [];

        if (! isset($this->data['contract']) || false == ($this->data['contract'] instanceof Contract)) {
            // Maybe wrong context => Show no invoice
            return $this->data;
        }

        $searchInvoice = new Invoice();
        $searchInvoice->setContract($this->data['contract']);

        $this->data['invoices'] = $this->repository->findAllSimilar($searchInvoice);

        return $this->data;
    }

    /**
     * Return a unique identifier among all known boardlets.
     *
     * @return string
     */
    public function getId()
    {
        return 'crmp_accounting.contract.related_panel.invoices';
    }

    /**
     * Override default template.
     *
     * @return string
     */
    public function getTemplate()
    {
        return 'CrmpAccountingBundle:Contract:_panel-invoice.html.twig';
    }

    /**
     * Return the name of this panel.
     *
     * @return string
     */
    public function getTitle()
    {
        return 'crmp_accounting.invoice.plural';
    }
}
