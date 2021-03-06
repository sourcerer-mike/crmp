<?php

namespace Crmp\AccountingBundle\Panel\Customer;

use Crmp\AccountingBundle\Entity\Invoice;
use Crmp\CrmBundle\Entity\Customer;
use Crmp\CrmBundle\Twig\AbstractPanel;
use Crmp\CrmBundle\Twig\PanelInterface;

/**
 * Panel about invoices when viewing a single customer.
 *
 * @package Crmp\AccountingBundle\Panel\Customer
 */
class InvoicePanel extends AbstractPanel implements PanelInterface
{
    /**
     * Gather invoices for the current customer.
     *
     * @return \ArrayObject
     */
    public function getData()
    {
        if (isset($this->data['invoices']) && count($this->data['invoices'])) {
            // Seems like already fetched before => return cached data
            return $this->data;
        }

        $this->data['invoices'] = [];

        if (! isset($this->data['customer']) || false == ($this->data['customer'] instanceof Customer)) {
            return $this->data;
        }

        // filter
        $invoice = new Invoice();
        $invoice->setCustomer($this->data['customer']);
        $this->data['invoices'] = $this->repository->findAllSimilar($invoice);

        return $this->data;
    }

    /**
     * Return a unique identifier among all known boardlets.
     *
     * @return string
     */
    public function getId()
    {
        return 'crmp_accounting.customer.related_panel.invoices';
    }

    /**
     * Override default template.
     *
     * @return string
     */
    public function getTemplate()
    {
        return 'CrmpAccountingBundle:Customer:_panel-invoice.html.twig';
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
