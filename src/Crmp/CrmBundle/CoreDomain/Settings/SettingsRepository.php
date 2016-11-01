<?php

namespace Crmp\CrmBundle\CoreDomain\Settings;

use Crmp\CoreDomain\Settings\Setting;
use Crmp\CoreDomain\Settings\SettingRepositoryInterface;
use Doctrine\Common\Collections\Criteria;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityRepository;

/**
 * Access the settings repository.
 *
 * @package Crmp\CrmBundle\CoreDomain\Settings
 */
class SettingsRepository implements SettingRepositoryInterface
{
    /**
     * Doctrine repository for the entity.
     *
     * @var EntityRepository
     */
    protected $repository;

    /**
     * Entity manager to access the database.
     *
     * @var EntityManager
     */
    private $entitiyManager;

    /**
     * SettingsRepository constructor.
     *
     * @param EntityManager    $entityManager
     * @param EntityRepository $settingRepository
     */
    public function __construct(EntityManager $entityManager, EntityRepository $settingRepository)
    {
        $this->entitiyManager = $entityManager;
        $this->repository     = $settingRepository;
    }

    /**
     * Store a setting in the database.
     *
     * @param Setting $setting
     *
     * @return mixed
     */
    public function add(Setting $setting)
    {
        $this->entitiyManager->persist($setting);
    }

    /**
     * Fetch a single setting by ID.
     *
     * @param int $settingId
     *
     * @return \Crmp\CrmBundle\Entity\Setting
     */
    public function find($settingId)
    {
        return $this->repository->find($settingId);
    }

    /**
     * Fetch all settings.
     *
     * @param int $amount
     * @param int $start
     *
     * @return \Crmp\CrmBundle\Entity\Setting[]
     */
    public function findAll($amount = null, $start = null)
    {
        return $this->repository->findAll();
    }

    /**
     * Fetch settings similar to the given one.
     *
     * @param Setting $setting
     *
     * @return mixed
     */
    public function findSimilar(Setting $setting)
    {
        $criteria = Criteria::create();

        if ($setting->getUser()) {
            $criteria->andWhere($criteria->expr()->eq('user', $setting->getUser()));
        }

        if ($setting->getValue()) {
            $criteria->andWhere($criteria->expr()->eq('value', $setting->getValue()));
        }

        return $this->repository->matching($criteria);
    }

    /**
     * Remove a setting from the database.
     *
     * @param Setting $setting
     *
     * @return mixed
     */
    public function remove(Setting $setting)
    {
        $this->entitiyManager->remove($setting);
    }
}
