<?php


namespace Crmp\CrmBundle\CoreDomain\Address;

use Crmp\CrmBundle\Entity\Address;
use Crmp\CrmBundle\Repository\AddressRepository as AddressRepo;
use Crmp\CrmBundle\Repository\CustomerRepository as CustomerRepo;
use Doctrine\Common\Collections\Criteria;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityRepository;

/**
 * Adapter to the storage of customer data.
 *
 * @package Crmp\CrmBundle\CoreDomain\Customer
 */
class AddressRepository
{
    /**
     * Injects the repository and entity manager.
     *
     * @param EntityRepository $addressRepository Final storage for data in doctrine.
     * @param EntityManager    $entityManager     Doctrine adapter to storage, needed for updates.
     */
    public function __construct(EntityRepository $addressRepository, EntityManager $entityManager)
    {
        $this->customerRepository = $addressRepository;
        $this->entityManager      = $entityManager;
    }

    /**
     * Fetch all addresses.
     *
     * @param null $amount
     * @param null $start
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function findAll($amount = null, $start = null)
    {
        $criteria = Criteria::create();

        if (null !== $amount) {
            $criteria->setMaxResults($amount);
        }

        if (null !== $start) {
            $criteria->setFirstResult($start);
        }

        return $this->customerRepository->matching($criteria);
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
     * @param Address $address
     */
    public function update(Address $address)
    {
        $this->entityManager->persist($address);
    }
}
