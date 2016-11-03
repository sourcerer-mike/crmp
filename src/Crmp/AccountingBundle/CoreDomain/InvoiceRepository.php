<?php


namespace Crmp\AccountingBundle\CoreDomain;

use Crmp\AccountingBundle\Entity\Invoice;
use Crmp\CoreDomain\RepositoryInterface;
use Crmp\CrmBundle\CoreDomain\AbstractRepository;

/**
 * Adapter to the doctrine storage for invoices.
 *
 * @package Crmp\AccountingBundle\CoreDomain
 */
class InvoiceRepository extends AbstractRepository implements RepositoryInterface
{
    /**
     * Fetch entities similar to the given one.
     *
     * @param Invoice $entity
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
            $criteria->andWhere($criteria->expr()->eq('customer', $entity->getCustomer()));
        }

        if ($entity->getContract()) {
            $criteria->andWhere($criteria->expr()->eq('contract', $entity->getContract()));
        }

        return $this->repository->matching($criteria);
    }
}
