<?php

namespace Crmp\CoreDomain;

/**
 * Interface how to use repositories.
 *
 * @package Crmp\CoreDomain
 */
interface RepositoryInterface
{
    /**
     * Store an entity in the database.
     *
     * @param object $entity
     */
    public function add($entity);

    /**
     * Fetch a single entitiy by ID.
     *
     * @param int $entityId Identifier for the entity.
     *
     * @return object|null
     */
    public function find($entityId);

    /**
     * Fetch all entities.
     *
     * @param int   $amount How many entities shall be returned.
     * @param int   $start  How many entities shall be skipped (usually for pagination).
     * @param array $order  Set how each column shall be ordered.
     *
     * @return \object[]
     */
    public function findAll($amount = null, $start = null, $order = []);

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
    public function findAllSimilar($entity, $amount = null, $start = null, $order = []);

    /**
     * Fetch one entity similar to the given one.
     *
     * @param object $entity
     *
     * @return object|null
     */
    public function findSimilar($entity);

    /**
     * Remove an entity from the database.
     *
     * @param object $entity
     *
     * @return mixed
     *
     */
    public function remove($entity);
}
