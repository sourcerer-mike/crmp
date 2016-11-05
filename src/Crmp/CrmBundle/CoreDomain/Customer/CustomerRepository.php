<?php


namespace Crmp\CrmBundle\CoreDomain\Customer;

use Crmp\CrmBundle\Entity\Customer;
use Crmp\CrmBundle\Repository\CustomerRepository as CustomerRepo;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityRepository;

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
     * @param EntityRepository $customerRepository Final storage for data in doctrine.
     * @param EntityManager    $entityManager      Doctrine adapter to storage, needed for updates.
     */
    public function __construct(EntityRepository $customerRepository, EntityManager $entityManager)
    {
        $this->customerRepository = $customerRepository;
        $this->entityManager      = $entityManager;
    }

    /**
     * Fetch a single customer.
     *
     * @param int $id ID of the customer.
     *
     * @return null|object|Customer
     */
    public function find($id)
    {
        return $this->customerRepository->find($id);
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
