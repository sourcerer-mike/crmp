<?php


namespace Crmp\CrmBundle\CoreDomain\Config;


use Crmp\CrmBundle\Repository\ConfigRepository as ConfigRepo;
use Doctrine\Common\Collections\Criteria;

class ConfigRepository implements ConfigRepositoryInterface
{
    /**
     * Access to the storage for configuration.
     *
     * @var ConfigRepo
     */
    protected $configRepository;


    /**
     * Hashes or keys about the current context.
     *
     * An option can be retrieved by using `::get('path.with.dots')`.
     * This will search for every config named 'path.with.dots'
     * which have one of the scopes provided by the context hash.
     *
     * @see ::get
     *
     * @var array|\string[]
     */
    protected $contextHashes = array('default');

    /**
     * ConfigRepository constructor.
     *
     * @param ConfigRepo $configRepository Storage with some configurations.
     * @param string[]   $contextHashes    User that access the storage.
     *                                     Deprecated in 1.0.0 as this is needed in the interface / core domain.
     */
    public function __construct(ConfigRepo $configRepository, $contextHashes = null)
    {
        $this->configRepository = $configRepository;

        if (null !== $contextHashes) {
            $this->contextHashes = $contextHashes;
        }

        $this->criteria = Criteria::create()
                                  ->where(Criteria::expr()->in('context', $this->contextHashes));
    }

    /**
     * Fetch a configuration from the storage.
     *
     * @param string $path Node of the configuration.
     *
     * @return string|null The value or null if nothing found.
     */
    public function get($path)
    {
        $config = $this->configRepository->findOneBy(
            [
                'path' => $path,
            ]
        );

        if (! $config) {
            return null;
        }

        return $config->value;
    }
}