<?php

namespace Crmp\CrmBundle\CoreDomain;

use Crmp\CoreDomain\RepositoryInterface;
use Crmp\CoreDomain\Settings\Setting;
use Doctrine\Common\Collections\Criteria;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityRepository;

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
     * @param EntityRepository $settingRepository
     * @param EntityManager    $entityManager
     */
    public function __construct(EntityRepository $settingRepository, EntityManager $entityManager)
    {
        $this->repository    = $settingRepository;
        $this->entityManager = $entityManager;
    }

    /**
     * Store a setting in the database.
     *
     * @param Setting $entity
     *
     * @return mixed
     */
    public function add($entity)
    {
        $this->entityManager->persist($entity);
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
        $this->findAllSimilar($entity, 1)->first();
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