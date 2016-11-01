<?php

namespace Crmp\CrmBundle\Entity;

/**
 * Setting
 */
class Setting extends \Crmp\CoreDomain\Settings\Setting
{
    /**
     * @var \AppBundle\Entity\User
     */
    protected $user;

    /**
     * Set user
     *
     * @param \AppBundle\Entity\User $user
     *
     * @return Setting
     */
    public function setUser($user = null)
    {
        $this->user = $user;

        return $this;
    }
}
