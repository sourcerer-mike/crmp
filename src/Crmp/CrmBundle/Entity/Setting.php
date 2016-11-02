<?php

namespace Crmp\CrmBundle\Entity;

/**
 * Setting
 */
class Setting extends \Crmp\CoreDomain\Settings\Setting
{
    /**
     * @var \Crmp\CrmBundle\Entity\User
     */
    protected $user;

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
}
