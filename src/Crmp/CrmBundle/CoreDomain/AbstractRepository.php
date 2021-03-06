<?php

namespace Crmp\CrmBundle\CoreDomain;

use Crmp\CoreDomain\RepositoryInterface;
use Crmp\CoreDomain\Settings\Setting;
use Doctrine\Common\Collections\Criteria;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityRepository;

/**
 * Abstract capabilities of a repository.
 *
 * @package Crmp\CrmBundle\CoreDomain
 */
abstract class AbstractRepository implements RepositoryInterface
{
    const ORDER_ASC  = Criteria::ASC;
    const ORDER_DESC = Criteria::DESC;
    /**
     * Entity manager to access the database.
     *
     * @var EntityManager
     */
    protected $entityManager;
    /**
     * Doctrine repository for the entity.
     *
     * @var EntityRepository
     */
    protected $repository;

    /**
     * SettingsRepository constructor.
     *
     * @param EntityRepository $entityRepository
     * @param EntityManager    $entityManager
     */
    public function __construct(EntityRepository $entityRepository, EntityManager $entityManager)
    {
        $this->repository    = $entityRepository;
        $this->entityManager = $entityManager;
    }

    /**
     * Store a setting in the database.
     *
     * @param object $entity
     *
     * @return mixed
     */
    public function persist($entity)
    {
        $this->entityManager->persist($entity);
        $this->entityManager->flush($entity);
    }

    /**
     * Fetch a single entitiy by ID.
     *
     * @param int $entityId Identifier for the entity.
     *
     * @return object|null
     */
    public function find($entityId)
    {
        return $this->repository->find($entityId);
    }

    /**
     * Fetch all entities.
     *
     * @param int   $amount How many entities shall be returned.
     * @param int   $start  How many entities shall be skipped (usually for pagination).
     *
     * @param array $order
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function findAll($amount = null, $start = null, $order = [])
    {
        return $this->repository->matching(
            $this->createCriteria($amount, $start, $order)
        );
    }

    /**
     * Fetch one entity similar to the given one.
     *
     * @param object $entity
     *
     * @return object|null
     */
    public function findSimilar($entity)
    {
        return $this->findAllSimilar($entity, 1)->first();
    }

    /**
     * Remove an entity from the database.
     *
     * @param object $entity
     *
     * @return mixed
     *
     */
    public function remove($entity)
    {
        $this->entityManager->remove($entity);
    }

    /**
     * Create a new search criteria.
     *
     * @param int   $amount
     * @param int   $start
     * @param array $order
     *
     * @return Criteria
     */
    protected function createCriteria($amount = null, $start = null, $order = [])
    {
        $criteria = Criteria::create();

        if (null !== $amount) {
            $criteria->setMaxResults($amount);
        }

        if (null !== $start) {
            $criteria->setFirstResult($start);
        }

        if ($order) {
            $criteria->orderBy($order);
        }

        return $criteria;
    }
}
