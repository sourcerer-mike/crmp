<?php


namespace Crmp\AcquisitionBundle\CoreDomain\Offer;

use Crmp\AcquisitionBundle\Entity\Offer;
use Crmp\CoreDomain\RepositoryInterface;
use Crmp\CrmBundle\CoreDomain\AbstractRepository;

/**
 * Adapter to doctrine for managing offers.
 *
 * @package Crmp\AcquisitionBundle\CoreDomain\Offer
 */
class OfferRepository extends AbstractRepository implements RepositoryInterface
{
    /**
     * Fetch entities similar to the given one.
     *
     * @param Offer $entity
     * @param int   $amount
     * @param int   $start
     * @param array $order
     *
     * @return \object[]
     */
    public function findAllSimilar($entity, $amount = null, $start = null, $order = [])
    {
        $criteria = $this->createCriteria($amount, $start, $order);

        if ($entity->getCustomer()) {
            $criteria->andWhere($criteria->expr()->eq('customer', $entity->getCustomer()));
        }

        if ($entity->getInquiry()) {
            $criteria->andWhere($criteria->expr()->eq('inquiry', $entity->getInquiry()));
        }

        return $this->repository->matching($criteria);
    }
}
