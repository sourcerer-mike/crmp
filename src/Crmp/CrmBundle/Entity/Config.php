<?php

namespace Crmp\CrmBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Configuration in CRMP
 *
 * The general configuration is manages with the Config-Entity.
 * It provides a flat structure for simple data.
 *
 * @ORM\Table(name="config")
 * @ORM\Entity(repositoryClass="Crmp\CrmBundle\Repository\ConfigRepository")
 */
class Config
{
    /**
     * Configuration path.
     *
     * Every configuration is grouped in bundles followed by the identifier itself.
     * So each bundle can have it's own configuration when it's written like "crmp_crm.sessionTimeout".
     * It prevents the identifier of the config data from colliding with identifier from other bundles.
     * Usually a configuration path with bundle alias and identifier is short
     * but here it can go up to 255 characters.
     *
     * @var string
     *
     * @ORM\Column(name="path", type="string", length=255)
     */
    private $path;

    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * Configuration per user.
     *
     * Each configuration can be changed by the user.
     * Bundles may provide a default configuration but the user can override this.
     *
     * @var string
     *
     * @todo Make this related 1:1 to the user entity.
     *
     * @ORM\Column(name="user", type="string", length=255)
     */
    private $userId;

    /**
     * Configuration value itself.
     *
     * The most important thing about configuration is the value itself.
     * It should only store flat data because values are limited to 255 characters.
     * Other data that needs more space shall be managed by the bundles.
     *
     * @var string
     *
     * @ORM\Column(name="value", type="string", length=255, unique=true)
     */
    private $value;

    /**
     * Get all possible statuses.
     *
     * @deprecated 1.0.0 This is to hard coded and should be replaced by the core comain ConfigRepository.
     *
     * @param string $path
     *
     * @return array
     */
    public static function getChoices($path)
    {
        return [
            'crmp_acquisition.inquiry.status.open'     => 0,
            'crmp_acquisition.inquiry.status.done'     => 1,
            'crmp_acquisition.inquiry.status.canceled' => 2,
        ];
    }
}
