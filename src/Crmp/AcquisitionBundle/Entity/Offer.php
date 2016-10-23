<?php

namespace Crmp\AcquisitionBundle\Entity;

use Crmp\CrmBundle\Entity\Config;
use Crmp\CrmBundle\Entity\Customer;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Offer
 *
 * An entity to manage your quotes and track them for each customer.
 *
 * @ORM\Table(name="offer")
 * @ORM\Entity(repositoryClass="Crmp\AcquisitionBundle\Repository\OfferRepository")
 */
class Offer
{
    /**
     * @ORM\ManyToOne(targetEntity="Inquiry", inversedBy="offers")
     * @ORM\JoinColumn(name="inquiry_id", referencedColumnName="id")
     */
    protected $inquiry;

    /**
     * Quotation text.
     *
     * Every offer shall be described in a large quotation text to let everyone (esp. the customer)
     * know what it's all about.
     * It can be a large text as large as your database can bare.
     *
     * @var string
     *
     * @ORM\Column(name="content", type="text")
     */
    private $content;
    /**
     * @ORM\OneToMany(targetEntity="Contract", mappedBy="offer")
     */
    private $contracts;

    /**
     * @ORM\ManyToOne(targetEntity="Crmp\CrmBundle\Entity\Customer")
     * @ORM\JoinColumn(name="customer_id", referencedColumnName="id")
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
     * Value of the offer.
     *
     * The price or quote value is given without taxes for a better internal workflow.
     * It can be any number with four digits and up to 16 decimals in total.
     *
     * @var string
     *
     * @ORM\Column(name="price", type="decimal", precision=16, scale=4)
     */
    private $price;
    /**
     * Approval status.
     *
     * The status shows in which step the offer is.
     * It shall be extended via configuration at later time.
     * For now it only covers some common states.
     *
     * @todo Make it extensible.
     *
     * @ORM\Column(name="status", type="integer")
     */
    private $status;
    /**
     * Subject of the offer.
     *
     * The offer subject is a title for the whole document
     * and reduces all it's content to a small text.
     * The text can be 255 characters long but should be short for a better understanding.
     *
     * @var string
     *
     * @ORM\Column(name="title", type="string", length=255)
     */
    private $title;

    /**
     * Timestamp when the offer has been edited.
     *
     * You might want to track when the latest change has happened,
     * to keep your data up-to-date or filter out old offers.
     * Every time a offer information is changed,
     * the date and time is stored.
     *
     * @ORM\Column(type="datetime")
     */
    private $updatedAt;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->contracts = new ArrayCollection();
    }

    /**
     * String representation of the offer.
     *
     * Usually the title.
     *
     * @return string
     */
    public function __toString()
    {
        return $this->getTitle();
    }

    /**
     * Add contract
     *
     * @param Contract $contract
     *
     * @return Offer
     */
    public function addContract(Contract $contract)
    {
        $this->contracts[] = $contract;

        return $this;
    }

    /**
     * Store the update date before every update.
     *
     * @preUpdate
     */
    public function doPreUpdate()
    {
        $this->setUpdatedAt(new \DateTime());
    }

    /**
     * Get content
     *
     * @return string
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * Set content
     *
     * @param string $content
     *
     * @return Offer
     */
    public function setContent($content)
    {
        $this->content = $content;

        return $this;
    }

    /**
     * Get contracts
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getContracts()
    {
        return $this->contracts;
    }

    /**
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
     * @return Offer
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
     * Get inquiry
     *
     * @return Inquiry
     */
    public function getInquiry()
    {
        return $this->inquiry;
    }

    /**
     * Set inquiry
     *
     * @param Inquiry $inquiry
     *
     * @return Offer
     */
    public function setInquiry(Inquiry $inquiry = null)
    {
        $this->inquiry = $inquiry;

        return $this;
    }

    /**
     * Get price
     *
     * @return string
     */
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * Set price
     *
     * @param string $price
     *
     * @return Offer
     */
    public function setPrice($price)
    {
        $this->price = $price;

        return $this;
    }

    /**
     * Get status
     *
     * @return integer
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * Set status
     *
     * @param integer $status
     *
     * @return Offer
     */
    public function setStatus($status)
    {
        $this->status = $status;

        return $this;
    }

    /**
     * Label for the status choice.
     *
     * @return string
     */
    public function getStatusLabel()
    {
        $map = Config::getChoices('acquisition.offer.status');

        return (string) array_search($this->getStatus(), $map, true);
    }

    /**
     * Get title
     *
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set title
     *
     * @param string $title
     *
     * @return Offer
     */
    public function setTitle($title)
    {
        $this->title = $title;

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
     * @return static
     */
    public function setUpdatedAt($updatedAt)
    {
        if ($updatedAt->getTimestamp() > time() + 86400) {
            // time travel is impossible => dates in distant future are not allowed
            throw new \InvalidArgumentException(
                'The update date can not be in the future.'
            );
        }

        $this->updatedAt = $updatedAt;

        return $this;
    }

    /**
     * Check if the current contract has been ordered.
     *
     * @return bool
     */
    public function isOrdered()
    {
        return ! $this->getContracts()->isEmpty();
    }

    /**
     * Remove contract
     *
     * @param Contract $contract
     */
    public function removeContract(Contract $contract)
    {
        $this->contracts->removeElement($contract);
    }
}
