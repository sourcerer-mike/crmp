<?php


namespace Crmp\AccountingBundle\CoreDomain;

use Crmp\AccountingBundle\Entity\Invoice;
use Crmp\AccountingBundle\Repository\InvoiceRepository as InvoiceRepo;
use Doctrine\ORM\EntityManager;

/**
 * Adapter to the doctrine storage for invoices.
 *
 * @package Crmp\AccountingBundle\CoreDomain
 */
class InvoiceRepository
{
    /**
     * Inject doctrine entity manager and invoice repository.
     *
     * @param InvoiceRepo   $invoiceRepository
     * @param EntityManager $entityManager
     */
    public function __construct(InvoiceRepo $invoiceRepository, EntityManager $entityManager)
    {
        $this->invoiceRepository = $invoiceRepository;
        $this->entityManager     = $entityManager;
    }

    /**
     * Send invoice changes to storage.
     *
     * @param Invoice $invoice
     */
    public function update(Invoice $invoice)
    {
        $this->entityManager->persist($invoice);
    }
}
