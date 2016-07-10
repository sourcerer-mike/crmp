<?php

namespace Crmp\AcquisitionBundle\Entity;

use Crmp\CrmBundle\Entity\Config;
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
     * Constructor
     */
    public function __construct()
    {
        $this->contracts = new \Doctrine\Common\Collections\ArrayCollection();
    }

    public function __toString()
    {
        return $this->getTitle();
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
     * Add contract
     *
     * @param \Crmp\AcquisitionBundle\Entity\Contract $contract
     *
     * @return Offer
     */
    public function addContract(\Crmp\AcquisitionBundle\Entity\Contract $contract)
    {
        $this->contracts[] = $contract;

        return $this;
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
     * @return \Crmp\AcquisitionBundle\Entity\Inquiry
     */
    public function getInquiry()
    {
        return $this->inquiry;
    }

    /**
     * Set inquiry
     *
     * @param \Crmp\AcquisitionBundle\Entity\Inquiry $inquiry
     *
     * @return Offer
     */
    public function setInquiry(\Crmp\AcquisitionBundle\Entity\Inquiry $inquiry = null)
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

    public function isOrdered()
    {
        return ! $this->getContracts()->isEmpty();
    }

    /**
     * @return \Crmp\CrmBundle\Entity\Customer
     */
    public function getCustomer()
    {
        return $this->customer;
    }

    /**
     * Remove contract
     *
     * @param \Crmp\AcquisitionBundle\Entity\Contract $contract
     */
    public function removeContract(\Crmp\AcquisitionBundle\Entity\Contract $contract)
    {
        $this->contracts->removeElement($contract);
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
     * Get status
     *
     * @return integer
     */
    public function getStatus()
    {
        return $this->status;
    }

    public function getStatusLabel()
    {
        $map = Config::getChoices('acquisition.offer.status');

        return array_search($this->getStatus(), $map, true);
    }

    /**
     * Set customer
     *
     * @param \Crmp\CrmBundle\Entity\Customer $customer
     *
     * @return Offer
     */
    public function setCustomer(\Crmp\CrmBundle\Entity\Customer $customer = null)
    {
        $this->customer = $customer;

        return $this;
    }
}
