<?php

namespace Crmp\AccountingBundle\Tests\CoreDomain\InvoiceRepository;

use Crmp\AccountingBundle\CoreDomain\InvoiceRepository;
use Crmp\AccountingBundle\Entity\Invoice;
use Crmp\AcquisitionBundle\Entity\Contract;
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
        $entity = $this->createEntity();

        $entity->setCustomer($customer = new Customer());
        $customer->setName(uniqid());

        $this->assertFilteredBy('customer', $customer, $entity);
    }

    public function testItCanFilterByContract()
    {
        // filter data
        $entity = $this->createEntity();

        $contract = new Contract();
        $entity->setContract($contract);
        $contract->setTitle(uniqid());

        $this->assertFilteredBy('contract', $contract, $entity);
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
