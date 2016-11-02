<?php

namespace Crmp\CoreDomain\Settings;

use Crmp\CrmBundle\Entity\User;

/**
 * Single setting.
 *
 * @package Crmp\CoreDomain\Settings
 */
class Setting
{
    /**
     * @var integer
     */
    protected $id;
    /**
     * @var string
     */
    protected $name;
    /**
     * @var User|int
     */
    protected $user;
    /**
     * @var string
     */
    protected $value;

    /**
     * Create new setting.
     *
     * @param null $id
     */
    public function __construct($id = null)
    {
        $this->id = $id;
    }

    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Get user
     *
     * @return \Crmp\CrmBundle\Entity\User|int
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * Get value
     *
     * @return string
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * Set name
     *
     * @param string $name
     *
     * @return Setting
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Set user
     *
     * @param \Crmp\CrmBundle\Entity\User $user
     *
     * @return Setting
     */
    public function setUser($user = null)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Set value
     *
     * @param string $value
     *
     * @return Setting
     */
    public function setValue($value)
    {
        $this->value = $value;

        return $this;
    }
}
