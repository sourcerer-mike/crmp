<?php

namespace Crmp\CoreDomain\Settings;

use AppBundle\Entity\User;
use Crmp\CoreDomain\RepositoryInterface;

/**
 * Interface SettingRepositoryInterface.
 *
 * @package Crmp\CoreDomain\Settings
 */
interface SettingRepositoryInterface extends RepositoryInterface
{
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
    public function get($name, User $user = null);

    /**
     * Set the value of a setting.
     *
     * @param string    $name  Name of the setting.
     * @param string    $value Value of the setting.
     * @param null|User $user  Setting will be stored for this user (use NULL to set the default value for all).
     *
     * @return mixed
     */
    public function set($name, $value, User $user = null);
}
