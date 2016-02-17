<?php

namespace Crmp\CrmBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Address
 *
 * @ORM\Table(name="address")
 * @ORM\Entity(repositoryClass="Crmp\CrmBundle\Repository\AddressRepository")
 */
class Config
{
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
     * @ORM\Column(name="path", type="string", length=255, unique=true)
     */
    private $bundle;

    /**
     * @var string
     *
     * @ORM\Column(name="value", type="string", length=64, unique=true)
     */
    private $value;

    public static function getChoices($path)
    {
        return [
            'open'     => 0,
            'done'  => 1,
            'canceled' => 2,
        ];
    }
}
