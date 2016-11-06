<?php


namespace Crmp\CrmBundle\Tests\Controller\AbstractRepositoryController;


use Crmp\CoreDomain\RepositoryInterface;
use Crmp\CrmBundle\CoreDomain\AbstractRepository;

class StubRepository extends AbstractRepository implements RepositoryInterface
{
    /**
     * Fetch entities similar to the given one.
     *
     * @param object $entity
     * @param int    $amount
     * @param int    $start
     * @param array  $order
     *
     * @return \object[]
     */
    public function findAllSimilar($entity, $amount = null, $start = null, $order = [])
    {
        return [];
    }
}
