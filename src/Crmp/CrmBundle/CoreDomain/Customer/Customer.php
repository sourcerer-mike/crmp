<?php

namespace Crmp\CrmBundle\CoreDomain\Customer;

use Crmp\AccountingBundle\Entity\Invoice;
use Crmp\CrmBundle\Entity\Address;

/**
 * Definition of a customer.
 *
 * @package Crmp\CrmBundle\CoreDomain\Customer
 */
class Customer
{
    /**
     * Related addresses.
     *
     * Each customer can have none or more addresses attached to them.
     * The address itself refer to a single customer.
     * Thus it is not possible for an address to match on two customers at once.
     * It might become handy for a person working for two or more companies.
     * In this case please create the single address multiple times or only once for the one major customer.
     */
    protected $addresses;
    /**
     * @var int
     */
    protected $id;
    /**
     * @var Invoice[]
     */
    protected $invoices;
    /**
     * Firm of the company.
     *
     * Companies usually have a title/name/firm that they are known by.
     * The "name" field is mend for the full title of a company as registered by the state.
     * A name can be 255 chars long and are treated as unique.
     * So when you try to store a company that already exists an error might be thrown.
     *
     * @var string
     */
    protected $name;

    /**
     * Get addresses
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getAddresses()
    {
        return $this->addresses;
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
     * Get invoices
     *
     * @return \Crmp\AccountingBundle\Entity\Invoice[]
     */
    public function getInvoices()
    {
        return $this->invoices;
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
     * @return static
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }
}
