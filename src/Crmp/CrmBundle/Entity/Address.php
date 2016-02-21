<?php

namespace Crmp\CrmBundle\Entity;

use AppBundle\Entity\User;
use Doctrine\ORM\Mapping as ORM;

/**
 * Address
 *
 * @ORM\Table(name="address")
 * @ORM\Entity(repositoryClass="Crmp\CrmBundle\Repository\AddressRepository")
 *
 * @ORM\HasLifecycleCallbacks
 */
class Address
{

    /**
     * @var Customer
     *
     * @ORM\ManyToOne(targetEntity="Crmp\CrmBundle\Entity\Customer", inversedBy="addresses")
     * @ORM\JoinColumn(fieldName="customer_id", referencedColumnName="id")
     */
    private $customer;

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
     * @ORM\Column(name="mail", type="string", length=255, unique=true)
     */
    private $mail;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $name;

    /**
     * @ORM\Column(type="datetime")
     */
    private $updatedAt;

    /**
     * @ORM\ManyToOne(targetEntity="\AppBundle\Entity\User")
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
        $this->setUpdatedAt(new \DateTime());
    }

    /**
     * @ORM\PreUpdate
     */
    public function preUpdate()
    {
        $this->setUpdatedAt(new \DateTime());
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
     * Get updatedBy
     *
     * @return User
     */
    public function getUpdatedBy()
    {
        return $this->updatedBy;
    }
}
