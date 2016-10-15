<?php


namespace Crmp\CrmBundle\CoreDomain\Config;

interface ConfigRepositoryInterface
{
    /**
     * Fetch a configuration from the storage.
     *
     * @param string $path Node of the configuration.
     *
     * @return string|null The value or null if nothing found.
     */
    public function get($path);
}