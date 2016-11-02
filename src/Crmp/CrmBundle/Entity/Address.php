<?php

namespace Crmp\CrmBundle\Entity;

use Crmp\CrmBundle\Entity\User;
use Doctrine\ORM\Mapping as ORM;

/**
 * Address
 *
 * Addresses are important to contact someone, write invoices or know who is responsible for what.
 *
 */
class Address
{

    /**
     * @var Customer
     *
     */
    private $customer;

    /**
     * @var int
     *
     */
    private $id;

    /**
     * E-Mail address.
     *
     * Everyone has a mail address nowadays which makes it easier for salesmen to send offers
     * or ask something about the current project.
     * A mail address can take up to 255 characters in total.
     * It is unique so that one mail address can only be taken by one contact.
     *
     * @var string
     */
    private $mail;

    /**
     * Name of the contact.
     *
     * The full name of the other person helps you search it in the database
     * or write letters to them.
     * It can be any name up to 255 characters.
     *
     * @var string
     */
    private $name;

    /**
     * Timestamp when the address has been edited.
     *
     * You might want to track when the latest change has happened,
     * to keep your data up-to-date or filter out old contacts.
     * The date and time is stored every time the address is changed.
     */
    private $updatedAt;

    /**
     * The last person who edited.
     *
     * When you see that data has changed,
     * you might want to ask a person why and what has changed.
     * To have someone responsible or keep a history of changes the last person is stored on every change.
     */
    private $updatedBy;

    /**
     * Get customer
     *
     * @return Customer
     */
    public function getCustomer()
    {
        return $this->customer;
    }

    /**
     * Set customer
     *
     * @param Customer $customer
     *
     * @return Address
     */
    public function setCustomer(Customer $customer = null)
    {
        $this->customer = $customer;

        return $this;
    }

    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Get mail
     *
     * @return string
     */
    public function getMail()
    {
        return $this->mail;
    }

    /**
     * Set mail
     *
     * @param string $mail
     *
     * @return Address
     */
    public function setMail($mail)
    {
        $this->mail = $mail;

        return $this;
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
     * Set name
     *
     * @param string $name
     *
     * @return Address
     */
    public function setName($name)
    {
        $this->name = $name;

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
     * @return Address
     */
    public function setUpdatedAt($updatedAt)
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    /**
     * Get updatedBy
     *
     * @return User
     */
    public function getUpdatedBy()
    {
        return $this->updatedBy;
    }

    /**
     * Set updatedBy
     *
     * @param User $updatedBy
     *
     * @return Address
     */
    public function setUpdatedBy(User $updatedBy = null)
    {
        $this->updatedBy = $updatedBy;

        return $this;
    }

    /**
     * Before creating address.
     */
    public function prePersist()
    {
        $this->setUpdatedAt(new \DateTime());
    }

    /**
     * Before updating address.
     */
    public function preUpdate()
    {
        $this->setUpdatedAt(new \DateTime());
    }
}
