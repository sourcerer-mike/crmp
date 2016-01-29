<?php

namespace Crmp\CrmBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Customer
 *
 * @ORM\Table(name="customer")
 * @ORM\Entity(repositoryClass="Crmp\CrmBundle\Repository\CustomerRepository")
 */
class Customer
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
     * @ORM\Column(name="name", type="string", length=255, unique=true)
     */
    private $name;

    /**
     * @ORM\OneToMany(targetEntity="\Crmp\AcquisitionBundle\Entity\Inquiry", mappedBy="customer")
     */
    protected $inquiries;

	/**
	 * @ORM\OneToMany(targetEntity="Crmp\CrmBundle\Entity\Address", mappedBy="customer")
	 */
	private $addresses;

	/**
	 * @ORM\OneToMany(targetEntity="Crmp\AccountingBundle\Entity\Invoice", mappedBy="customer")
	 */
	private $invoices;

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
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    public function __toString()
    {
        return $this->getName() . ' (' . $this->getId() . ')';
    }

    /**
     * Set name
     *
     * @param string $name
     *
     * @return Customer
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->inquiries = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add inquiry
     *
     * @param \Crmp\AcquisitionBundle\Entity\Inquiry $inquiry
     *
     * @return Customer
     */
    public function addInquiry(\Crmp\AcquisitionBundle\Entity\Inquiry $inquiry)
    {
        $this->inquiries[] = $inquiry;

        return $this;
    }

    /**
     * Remove inquiry
     *
     * @param \Crmp\AcquisitionBundle\Entity\Inquiry $inquiry
     */
    public function removeInquiry(\Crmp\AcquisitionBundle\Entity\Inquiry $inquiry)
    {
        $this->inquiries->removeElement($inquiry);
    }

    /**
     * Get inquiries
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getInquiries()
    {
        return $this->inquiries;
    }

    /**
     * Add address
     *
     * @param \Crmp\CrmBundle\Entity\Address $address
     *
     * @return Customer
     */
    public function addAddress(\Crmp\CrmBundle\Entity\Address $address)
    {
        $this->addresses[] = $address;

        return $this;
    }

    /**
     * Remove address
     *
     * @param \Crmp\CrmBundle\Entity\Address $address
     */
    public function removeAddress(\Crmp\CrmBundle\Entity\Address $address)
    {
        $this->addresses->removeElement($address);
    }

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
     * Add invoice
     *
     * @param \Crmp\AccountingBundle\Entity\Invoice $invoice
     *
     * @return Customer
     */
    public function addInvoice(\Crmp\AccountingBundle\Entity\Invoice $invoice)
    {
        $this->invoices[] = $invoice;

        return $this;
    }

    /**
     * Remove invoice
     *
     * @param \Crmp\AccountingBundle\Entity\Invoice $invoice
     */
    public function removeInvoice(\Crmp\AccountingBundle\Entity\Invoice $invoice)
    {
        $this->invoices->removeElement($invoice);
    }

    /**
     * Get invoices
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getInvoices()
    {
        return $this->invoices;
    }
}
