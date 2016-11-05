<?php

namespace Crmp\AcquisitionBundle\CoreDomain\Contract;

use Crmp\AcquisitionBundle\Entity\Contract;
use Crmp\CoreDomain\RepositoryInterface;
use Crmp\CrmBundle\CoreDomain\AbstractRepository;

/**
 * Storing and searching contracts.
 *
 * @package Crmp\AcquisitionBundle\CoreDomain\Contract
 */
class ContractRepository extends AbstractRepository implements RepositoryInterface
{
    /**
     * Fetch entities similar to the given one.
     *
     * @param Contract $entity
     * @param int      $amount
     * @param int      $start
     * @param array    $order
     *
     * @return \object[]
     */
    public function findAllSimilar($entity, $amount = null, $start = null, $order = [])
    {
        $criteria = $this->createCriteria($amount, $start, $order);

        if ($entity->getCustomer()) {
            $criteria->andWhere($criteria->expr()->eq('customer', $entity->getCustomer()));
        }

        if ($entity->getOffer()) {
            $criteria->andWhere($criteria->expr()->eq('offer', $entity->getOffer()));
        }

        return $this->repository->matching($criteria);
    }
}
