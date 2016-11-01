<?php

namespace Crmp\CoreDomain\Settings;

interface SettingRepositoryInterface
{
    /**
     * Store a setting in the database.
     *
     * @param Setting $setting
     *
     * @return mixed
     */
    public function add(Setting $setting);

    /**
     * Fetch a single setting by ID.
     *
     * @param int $settingId
     *
     * @return mixed
     */
    public function find($settingId);

    /**
     * Fetch all settings.
     *
     * @param int $amount
     * @param int $start
     *
     * @return mixed
     */
    public function findAll($amount = null, $start = null);

    /**
     * Fetch settings similar to the given one.
     *
     * @param Setting $setting
     *
     * @return mixed
     */
    public function findSimilar(Setting $setting);

    /**
     * Remove a setting from the database.
     *
     * @param Setting $setting
     *
     * @return mixed
     */
    public function remove(Setting $setting);
}
