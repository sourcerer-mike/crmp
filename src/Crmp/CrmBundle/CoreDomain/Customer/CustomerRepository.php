<?php


namespace Crmp\CrmBundle\CoreDomain\Customer;

use Crmp\CoreDomain\RepositoryInterface;
use Crmp\CrmBundle\CoreDomain\AbstractRepository;
use Crmp\CrmBundle\Entity\Customer as DoctrineCustomer;
use Crmp\CrmBundle\Repository\CustomerRepository as CustomerRepo;

/**
 * Adapter to the storage of customer data.
 *
 * @package Crmp\CrmBundle\CoreDomain\Customer
 */
class CustomerRepository extends AbstractRepository implements RepositoryInterface
{
    /**
     * Fetch entities similar to the given one.
     *
     * @param DoctrineCustomer $entity
     * @param int              $amount
     * @param int              $start
     * @param array            $order
     *
     * @return \object[]
     */
    public function findAllSimilar($entity, $amount = null, $start = null, $order = [])
    {
        $criteria = $this->createCriteria($amount, $start, $order);

        return $this->repository->matching($criteria);
    }
}
