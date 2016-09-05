<?php

namespace Crmp\Crm\DomainModel;

use Crmp\CrmBundle\Entity\Customer;
use Doctrine\ORM\Mapping as ORM;

/**
 * Address
 *
 * Addresses are important to contact someone, write invoices or know who is responsible for what.
 *
 * @ORM\HasLifecycleCallbacks
 */
class Address
{
    private $customer;

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

    public function __construct($id, $name, $mail, Customer $customer = null)
    {
        $this->id   = $id;
        $this->name = $name;
        $this->mail = $mail;
        $this->customer = $customer;
    }

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
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }
}
