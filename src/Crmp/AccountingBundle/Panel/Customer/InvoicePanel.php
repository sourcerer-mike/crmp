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
     * @return array
     */
    public function getData()
    {
        if ($this->data) {
            return (array) $this->data;
        }

        $this->data             = $this->container->get('crmp.controller.render.parameters');
        $this->data['invoices'] = [];

        if (! isset($this->data['customer']) || false == ($this->data['customer'] instanceof Customer)) {
            return (array) $this->data;
        }

        /** @var Customer $customer */
        $customer    = $this->data['customer'];
        $invoiceRepo = $this->container->get('crmp.invoice.repository');

        // filter
        $invoice = new Invoice();
        $invoice->setCustomer($customer);
        $this->data['invoices'] = $invoiceRepo->findAllSimilar($invoice);

        return (array) $this->data;
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
        return $this->container->get('translator')->trans('crmp_accounting.invoice.plural');
    }
}
