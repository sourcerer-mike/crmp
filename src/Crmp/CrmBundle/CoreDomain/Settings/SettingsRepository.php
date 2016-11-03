<?php

namespace Crmp\CrmBundle\CoreDomain\Settings;

use Crmp\CrmBundle\Entity\User;
use Crmp\CrmBundle\Entity\Setting;
use Crmp\CoreDomain\Settings\SettingRepositoryInterface;
use Crmp\CrmBundle\CoreDomain\AbstractRepository;
use Doctrine\Common\Collections\Criteria;

/**
 * Access the settings repository.
 *
 * @package Crmp\CrmBundle\CoreDomain\Settings
 */
class SettingsRepository extends AbstractRepository implements SettingRepositoryInterface
{
    /**
     * Pool for already fetched data.
     *
     * @var array
     */
    protected $data = [];

    /**
     * Add or update setting.
     *
     * @param \Crmp\CoreDomain\Settings\Setting|object $setting
     * @throws \InvalidArgumentException
     *
     * @return null
     */
    public function persist($setting)
    {
        /** @var Setting $existingSetting */
        $existingSetting = null;

        if (! $setting->getName()) {
            throw new \InvalidArgumentException('Settings need a name.');
        }

        if (! $setting->getId()) {
            // has no id yet => prevent storing duplicates
            $existingSetting = $this->findSimilar($setting);
        }

        if ($existingSetting) {
            // setting exists already => just change value
            $existingSetting->setValue($setting->getValue());
            $setting = $existingSetting;
        }

        parent::persist($setting);
    }

    /**
     * Fetch entities similar to the given one.
     *
     * @param object $setting
     * @param int    $amount
     * @param int    $start
     * @param array  $order
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function findAllSimilar($setting, $amount = null, $start = null, $order = [])
    {
        $criteria = $this->createCriteria($amount, $start, $order);

        if ($setting->getUser()) {
            $criteria->andWhere($criteria->expr()->eq('user', $setting->getUser()));
        }

        if ($setting->getName()) {
            $criteria->andWhere($criteria->expr()->eq('name', $setting->getName()));
        }

        return $this->repository->matching($criteria);
    }

    /**
     * Flush all operations to database.
     */
    public function flush()
    {
        $this->entityManager->flush();
    }

    /**
     * Get the value of a configuration.
     *
     * The setting will be retrieved for the given user first.
     * If not found then the default value (for user NULL) will be returned.
     * When the setting does not exists then NULL will be returned.
     *
     * @param string $name Name of the setting.
     * @param User   $user Setting as stored by this user (use NULL to get the default value).
     *
     * @return string|null Value of the setting.
     */
    public function get($name, User $user = null)
    {
        if (isset($this->data[$name])) {
            return $this->data[$name];
        }

        $setting = new Setting();
        $setting->setName($name);

        if ($user instanceof User) {
            $setting->setUser($user);
        }

        $found = $this->findSimilar($setting);

        if (! $found && $setting->getUser()) {
            // last search tried with specific user => check again for the default
            $setting->setUser(null);

            $found = $this->findSimilar($setting);
        }

        if (! $found) {
            return null;
        }

        return $this->data[$name] = $found->getValue();
    }

    /**
     * Set the value of a setting.
     *
     * @param string    $name  Name of the setting.
     * @param string    $value Value of the setting.
     * @param null|User $user  Setting will be stored for this user (use NULL to set the default value for all).
     *
     * @return mixed
     */
    public function set($name, $value, User $user = null)
    {
        $setting = new Setting();

        $setting->setName($name)->setValue($value)->setUser($user);

        $this->persist($setting);
    }
}
