<?php

namespace Crmp\CrmBundle\Tests\CoreDomain\Address\AddressRepository;

use Crmp\CrmBundle\CoreDomain\Address\AddressRepository;
use Crmp\CrmBundle\Entity\Address;
use Crmp\CrmBundle\Entity\Customer;
use Crmp\CrmBundle\Tests\CoreDomain\AbstractFindAllSimilarTestCase;
use Crmp\CrmBundle\Tests\CoreDomain\AbstractRepositoryTestCase;
use Doctrine\ORM\EntityManager;

/**
 * Testing the doctrine adapter for addresses.
 *
 * @see     AddressRepository::update()
 *
 * @package Crmp\CrmBundle\Tests\CoreDomain\Address\AddressRepository
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

    protected function createEntity()
    {
        return new Address();
    }

    /**
     * Get the current class name.
     *
     * @return string
     */
    protected function getRepositoryClassName()
    {
        return AddressRepository::class;
    }
}
