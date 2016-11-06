<?php

namespace Crmp\CrmBundle\Entity;

use Crmp\AccountingBundle\Entity\Invoice;
use Doctrine\ORM\Mapping as ORM;

/**
 * Customer
 *
 * The mostly used entity referring to plenty others is the customer itself.
 *
 */
class Customer extends \Crmp\CrmBundle\CoreDomain\Customer\Customer
{


    /**
     * Timestamp when this customer has been created.
     *
     * When the customer is created the "created at" field will be filled automatically with the current date and time.
     */
    private $createdAt;


    /**
     * Timestamp when the customer has been edited.
     *
     * You might want to track when the latest change has happened,
     * to keep your data up-to-date or filter out old customer.
     * Every time a customer information is changed,
     * the date and time is stored.
     */
    private $updatedAt;

    /**
     * Name and ID of customer as string representation.
     *
     * @deprecated 1.0.0 This was meant for forms. Back in the days when I were to stupid to use them. Cheers!
     *
     * @return string
     */
    public function __toString()
    {
        return $this->getName().' ('.$this->getId().')';
    }

    /**
     * Get createdAt
     *
     * @return \DateTime
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * Set createdAt
     *
     * @param \DateTime $createdAt
     *
     * @return Customer
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;

        return $this;
    }


    /**
     * Get updatedAt
     *
     * @return \DateTime
     */
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }

    /**
     * Set updatedAt
     *
     * @param \DateTime $updatedAt
     *
     * @return Customer
     */
    public function setUpdatedAt($updatedAt)
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    /**
     * Before creating new customer.
     */
    public function prePersist()
    {
        $this->setCreatedAt(new \DateTime());
        $this->setUpdatedAt(new \DateTime());
    }

    /**
     * Before updating customer.
     */
    public function preUpdate()
    {
        $this->setUpdatedAt(new \DateTime());
    }
}
