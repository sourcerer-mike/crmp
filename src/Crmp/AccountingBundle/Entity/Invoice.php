<?php

namespace Crmp\AccountingBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Invoice
 *
 * @ORM\Table(name="invoice")
 * @ORM\Entity(repositoryClass="Crmp\AccountingBundle\Repository\InvoiceRepository")
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
     * @var string
     *
     * @ORM\Column(name="value", type="decimal", precision=16, scale=4)
     */
    private $value;

	/**
	 * @ORM\ManyToOne(targetEntity="Crmp\CrmBundle\Entity\Customer", inversedBy="invoices")
	 */
	private $customer;

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
}
