<?php

namespace Crmp\CrmBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints\DateTime;

/**
 * Customer
 *
 * The mostly used entity referring to plenty others is the customer itself.
 *
 * @ORM\Table(name="customer")
 * @ORM\Entity(repositoryClass="Crmp\CrmBundle\Repository\CustomerRepository")
 *
 * @ORM\HasLifecycleCallbacks
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
     *
     * @ORM\OneToMany(targetEntity="Crmp\CrmBundle\Entity\Address", mappedBy="customer")
     */
    private $addresses;

    /**
     * Timestamp when this customer has been created.
     *
     * When the customer is created the "created at" field will be filled automatically with the current date and time.
     *
     * @ORM\Column(type="datetime")
     */
    private $createdAt;

    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * Firm of the company.
     *
     * Companies usually have a title/name/firm that they are known by.
     * The "name" field is mend for the full title of a company as registered by the state.
     * A name can be 255 chars long and are treated as unique.
     * So when you try to store a company that already exists an error might be thrown.
     *
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255, unique=true)
     */
    private $name;

    /**
     * Timestamp when the customer has been edited.
     *
     * You might want to track when the latest change has happened,
     * to keep your data up-to-date or filter out old customer.
     * Every time a customer information is changed,
     * the date and time is stored.
     *
     * @ORM\Column(type="datetime")
     */
    private $updatedAt;

    public function __toString()
    {
        return $this->getName().' ('.$this->getId().')';
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
     * @return Customer
     */
    public function setName($name)
    {
        $this->name = $name;

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
     * Get addresses
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getAddresses()
    {
        return $this->addresses;
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
     * Get invoices
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getInvoices()
    {
        return $this->invoices;
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
     * @ORM\PrePersist
     */
    public function prePersist()
    {
        $this->setCreatedAt(new \DateTime());
        $this->setUpdatedAt(new \DateTime());
    }

    /**
     *
     * @ORM\PreUpdate
     */
    public function preUpdate()
    {
        $this->setUpdatedAt(new \DateTime());
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
     * Remove invoice
     *
     * @param \Crmp\AccountingBundle\Entity\Invoice $invoice
     */
    public function removeInvoice(\Crmp\AccountingBundle\Entity\Invoice $invoice)
    {
        $this->invoices->removeElement($invoice);
    }
}
