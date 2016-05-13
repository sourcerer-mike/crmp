<?php

namespace Crmp\CrmBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Address
 *
 * @ORM\Table(name="config")
 * @ORM\Entity(repositoryClass="Crmp\CrmBundle\Repository\ConfigRepository")
 */
class Config
{
    /**
     * @var string
     *
     * @ORM\Column(name="path", type="string", length=255, unique=true)
     */
    private $bundle;
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;
    /**
     * @var string
     *
     * @ORM\Column(name="user", type="string", length=255)
     */
    private $userId;
    /**
     * @var string
     *
     * @ORM\Column(name="value", type="string", length=64, unique=true)
     */
    private $value;

    public static function getChoices($path)
    {
        return [
            'crmp.acquisition.inquiry.status.open'     => 0,
            'crmp.acquisition.inquiry.status.done'     => 1,
            'crmp.acquisition.inquiry.status.canceled' => 2,
        ];
    }
}
