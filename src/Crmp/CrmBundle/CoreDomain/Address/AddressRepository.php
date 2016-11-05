<?php


namespace Crmp\CrmBundle\CoreDomain\Address;

use Crmp\CoreDomain\RepositoryInterface;
use Crmp\CrmBundle\CoreDomain\AbstractRepository;
use Crmp\CrmBundle\Entity\Address;

/**
 * Adapter to the storage of customer data.
 *
 * @package Crmp\CrmBundle\CoreDomain\Customer
 */
class AddressRepository extends AbstractRepository implements RepositoryInterface
{
    /**
     * Fetch entities similar to the given one.
     *
     * @param Address $entity
     * @param int     $amount
     * @param int     $start
     * @param array   $order
     *
     * @return \object[]
     */
    public function findAllSimilar($entity, $amount = null, $start = null, $order = [])
    {
        $criteria = $this->createCriteria($amount, $start, $order);

        if ($entity->getCustomer()) {
            // Customer set => use for filtering
            $criteria->andWhere($criteria->expr()->eq('customer', $entity->getCustomer()));
        }

        return $this->repository->matching($criteria);
    }
}
