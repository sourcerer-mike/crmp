<?php

namespace Crmp\AccountingBundle\Tests\CoreDomain\InvoiceRepository;

use Crmp\AccountingBundle\CoreDomain\InvoiceRepository;
use Crmp\AccountingBundle\Entity\Invoice;
use Crmp\CrmBundle\Entity\Customer;
use Crmp\CrmBundle\Tests\CoreDomain\AbstractFindAllSimilarTestCase;

/**
 * Class FindAllSimilarTest
 *
 * @see     InvoiceRepository::findAllSimilar()
 *
 * @package Crmp\AccountingBundle\Tests\CoreDomain\InvoiceRepository
 */
class FindAllSimilarTest extends AbstractFindAllSimilarTestCase
{
    public function testItCanFilterByCustomer()
    {
        // filter data
        $invoice = new Invoice();

        $invoice->setCustomer($customer = new Customer());
        $customer->setName(uniqid());

        // expectations
        $entityRepoMock = $this->getEntitiyRepositoryMock();
        $repo           = $this->getRepositoryMock($entityRepoMock);

        $this->expectCriteria($entityRepoMock, 'customer', $customer);

        // Test
        /** @var InvoiceRepository $repo */
        $repo->findAllSimilar($invoice);
    }

    protected function createEntity()
    {
        return new Invoice();
    }

    protected function getRepositoryClassName()
    {
        return InvoiceRepository::class;
    }
}
