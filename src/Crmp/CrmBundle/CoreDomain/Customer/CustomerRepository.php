<?php


namespace Crmp\CrmBundle\CoreDomain\Customer;

use Crmp\CrmBundle\Entity\Customer;
use Crmp\CrmBundle\Repository\CustomerRepository as CustomerRepo;
use Doctrine\ORM\EntityManager;

/**
 * Adapter to the storage of customer data.
 *
 * @package Crmp\CrmBundle\CoreDomain\Customer
 */
class CustomerRepository
{
    /**
     * Injects the repository and entity manager.
     *
     * @param CustomerRepo  $customerRepository Final storage for data in doctrine.
     * @param EntityManager $entityManager      Doctrine adapter to storage, needed for updates.
     */
    public function __construct(CustomerRepo $customerRepository, EntityManager $entityManager)
    {
        $this->customerRepository = $customerRepository;
        $this->entityManager      = $entityManager;
    }

    /**
     * Flush the write cache.
     *
     * @param null $entity
     */
    public function flush($entity = null)
    {
        $this->entityManager->flush($entity);
    }

    /**
     * Set data for a customer.
     *
     * @param Customer $customer
     */
    public function update(Customer $customer)
    {
        $this->entityManager->persist($customer);
    }
}
