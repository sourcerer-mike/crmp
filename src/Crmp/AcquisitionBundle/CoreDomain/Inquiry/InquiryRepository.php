<?php


namespace Crmp\AcquisitionBundle\CoreDomain\Inquiry;

use Crmp\AcquisitionBundle\Entity\Inquiry;
use Crmp\AcquisitionBundle\Repository\InquiryRepository as InquiryRepo;
use Crmp\CrmBundle\CoreDomain\AbstractRepository;
use Doctrine\ORM\EntityManager;

/**
 * Adapter to doctrine for managing inquirys.
 *
 * @package Crmp\AcquisitionBundle\CoreDomain\Inquiry
 */
class InquiryRepository extends AbstractRepository
{
    /**
     * Fetch entities similar to the given one.
     *
     * @param Inquiry $inquiry
     * @param int     $amount
     * @param int     $start
     * @param array   $order
     *
     * @return \object[]
     */
    public function findAllSimilar($inquiry, $amount = null, $start = null, $order = [])
    {
        $criteria = $this->createCriteria($amount, $start, $order);

        if ($inquiry->getCustomer()) {
            $criteria->where($criteria->expr()->eq('customer', $inquiry->getCustomer()));
        }

        if ($inquiry->getStatus()) {
            $criteria->where($criteria->expr()->eq('status', $inquiry->getStatus()));
        }

        return $this->repository->matching($criteria);
    }
}
