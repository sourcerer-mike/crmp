<?php

namespace Crmp\AccountingBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Invoices
 *
 * Invoices are made after a contractor has done his duty to deliver goods or a service.
 * This entity keeps track of such invoices or helps creating them.
 *
 * @ORM\Table(name="invoice")
 * @ORM\Entity()
 */
class Invoice
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
     * Total cost that will be invoiced without tax.
     *
     * The total amount that will be invoiced is stored without taxes
     * for a easier and better workflow inside the company.
     * It can be a number with four digits and up to 16 cipher in total.
     *
     * @var string
     *
     * @ORM\Column(name="value", type="decimal", precision=16, scale=4)
     */
    private $value;

    /**
     * @ORM\ManyToOne(targetEntity="Crmp\CrmBundle\Entity\Customer")
     */
    private $customer;

    /**
     * @ORM\ManyToOne(targetEntity="Crmp\AcquisitionBundle\Entity\Contract")
     */
    private $contract;

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
     * Set value
     *
     * @param string $value
     *
     * @return Invoice
     */
    public function setValue($value)
    {
        $this->value = $value;

        return $this;
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
     * Set customer
     *
     * @param \Crmp\CrmBundle\Entity\Customer $customer
     *
     * @return Invoice
     */
    public function setCustomer(\Crmp\CrmBundle\Entity\Customer $customer = null)
    {
        $this->customer = $customer;

        return $this;
    }

    /**
     * Get customer
     *
     * @return \Crmp\CrmBundle\Entity\Customer
     */
    public function getCustomer()
    {
        return $this->customer;
    }

    /**
     * Set contract
     *
     * @param \Crmp\AcquisitionBundle\Entity\Contract $contract
     *
     * @return Invoice
     */
    public function setContract(\Crmp\AcquisitionBundle\Entity\Contract $contract = null)
    {
        $this->contract = $contract;

        return $this;
    }

    /**
     * Get contract
     *
     * @return \Crmp\AcquisitionBundle\Entity\Contract
     */
    public function getContract()
    {
        return $this->contract;
    }
}
