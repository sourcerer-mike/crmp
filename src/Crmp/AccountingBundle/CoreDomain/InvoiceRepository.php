<?php


namespace Crmp\AccountingBundle\CoreDomain;

use Crmp\AccountingBundle\Entity\Invoice;
use Crmp\AccountingBundle\Repository\InvoiceRepository as InvoiceRepo;
use Crmp\CoreDomain\RepositoryInterface;
use Crmp\CrmBundle\CoreDomain\AbstractRepository;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityRepository;

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

        return $this->repository->matching($criteria);
    }
}
