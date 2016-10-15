<?php

namespace Crmp\AcquisitionBundle\CoreDomain\Config;

use Crmp\CrmBundle\CoreDomain\Config\ConfigRepositoryInterface;

/**
 * Stub for some configurations.
 *
 * @package Crmp\AcquisitionBundle\CoreDomain\Config
 */
class ConfigRepositoryDecorator implements ConfigRepositoryInterface
{
    /**
     * Decorated object.
     *
     * @var ConfigRepositoryInterface
     */
    protected $configRepository;

    /**
     * ConfigRepositoryDecorator constructor.
     *
     * @param ConfigRepositoryInterface $configRepository
     */
    public function __construct(ConfigRepositoryInterface $configRepository)
    {
        $this->configRepository = $configRepository;
    }

    /**
     * Fetch a configuration from the storage.
     *
     * @param string $path Node of the configuration.
     *
     * @deprecated 1.0.0 Only for development purposes as long as there is no storage in the DB.
     *
     * @return string|null The value or null if nothing found.
     */
    public function get($path)
    {
        // Deprecated: Here we stub one configuration.
        if ('crmp_acquisition.offer.states' == $path) {
            return [
                'crmp_acquisition.offer.states.open'     => 0,
                'crmp_acquisition.offer.states.closed'   => 1,
                'crmp_acquisition.offer.states.rejected' => 2,
            ];
        }

        // pass to repo
        return $this->configRepository->get($path);
    }
}
