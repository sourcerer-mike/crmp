<?php

namespace Crmp\CrmBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints\DateTime;

/**
 * Customer
 *
 * @ORM\Table(name="customer")
 * @ORM\Entity(repositoryClass="Crmp\CrmBundle\Repository\CustomerRepository")
 *
 * @ORM\HasLifecycleCallbacks
 */
class Customer
{

    /**
     * @ORM\OneToMany(targetEntity="Crmp\CrmBundle\Entity\Address", mappedBy="customer")
     */
    private $addresses;

    /**
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
     * @ORM\OneToMany(targetEntity="Crmp\AccountingBundle\Entity\Invoice", mappedBy="customer")
     */
    private $invoices;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255, unique=true)
     */
    private $name;

    /**
     * @ORM\Column(type="datetime")
     */
    private $updatedAt;

    public function __toString()
    {
        return $this->getName().' ('.$this->getId().')';
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
     * @return \Doctrine\Common\Collections\Collection
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
     * Get updatedAt
     *
     * @return \DateTime
     */
    public function getUpdatedAt()
    {
        return $this->updatedAt;
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
}
