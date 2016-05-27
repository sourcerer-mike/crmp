<?php

namespace Crmp\AcquisitionBundle\Entity;

use Crmp\CrmBundle\Entity\Config;
use Doctrine\ORM\Mapping as ORM;

/**
 * Inquiries
 *
 * When a customer comes into your rooms or sends you a mail,
 * then every one in your business likes to keep track of that or delegate it.
 * CRMP offers a pool where you can just throw the inquiry in, keep track of them and generate offers or contracts.
 *
 * @ORM\Table(name="inquiry")
 * @ORM\Entity(repositoryClass="Crmp\AcquisitionBundle\Repository\InquiryRepository")
 */
class Inquiry
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
     * Subject of the inquiry.
     *
     * Reduce everything the customer wants in one sentence and less
     * to let others in your team quickly see what the topic is.
     * Make it any phrase shorter than 255 characters.
     *
     * @var string
     *
     * @ORM\Column(name="title", type="string", length=255)
     */
    private $title;

    /**
     * Estimated value.
     *
     * Estimate the value of the project / inquiry that the customer made,
     * so that all salesmen can sort them and make decisions based on that estimation.
     * Treat it as an really vague approximation
     * or something that is already said to the customer
     * for a better workflow.
     * It can be any value with four digits.
     * This is a mandatory information.
     *
     * @var string
     *
     * @ORM\Column(name="netValue", type="decimal", precision=4, scale=0, nullable=true)
     */
    private $netValue;

    /**
     * Description what the customer wants.
     *
     * Explain briefly what the customer wants
     * so that the salesmen or project executive can create an offer.
     *
     * @var string
     *
     * @ORM\Column(name="content", type="text", nullable=true)
     */
    private $content;

    /**
     * Date when the inquiry came in.
     *
     * Keep track of your oldest and youngest inquiries by setting a date,
     * so that salesmen can establish a workflow to achieve satisfied customers and/or thrifty projects.
     *
     * @var string
     *
     * @ORM\Column(type="datetime", name="inquired_at")
     */
    private $inquiredAt;

    /**
     * @ORM\ManyToOne(targetEntity="\Crmp\CrmBundle\Entity\Customer")
     * @ORM\JoinColumn(name="customer_id", referencedColumnName="id")
     */
    protected $customer;

    /**
     * @ORM\OneToMany(targetEntity="Offer", mappedBy="inquiry")
     */
    protected $offers;

    /**
     * Inquiry status.
     *
     * The status shows in which step the inquiry is.
     * It shall be extended via configuration at later time.
     * For now it only covers some common states.
     *
     * @todo Make it extensible.
     *
     * @ORM\Column(name="status", type="integer")
     */
    protected $status;


    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    public function __toString()
    {
        return $this->getTitle();
    }

    /**
     * Set title
     *
     * @param string $title
     *
     * @return Inquiry
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
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

	public function isOrdered() {
		/** @var Offer $offer */
		foreach ( $this->getOffers() as $offer ) {
			if ($offer->isOrdered()) {
				return true;
			}
		}

		return false;
	}

    /**
     * Set netValue
     *
     * @param string $netValue
     *
     * @return Inquiry
     */
    public function setNetValue($netValue)
    {
        $this->netValue = $netValue;

        return $this;
    }

    /**
     * Get netValue
     *
     * @return string
     */
    public function getNetValue()
    {
        return $this->netValue;
    }

    /**
     * Set content
     *
     * @param string $content
     *
     * @return Inquiry
     */
    public function setContent($content)
    {
        $this->content = $content;

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
     * Set customer
     *
     * @param \Crmp\CrmBundle\Entity\Customer $customer
     *
     * @return Inquiry
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
     * Constructor
     */
    public function __construct()
    {
        $this->offers = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add offer
     *
     * @param \Crmp\AcquisitionBundle\Entity\Offer $offer
     *
     * @return Inquiry
     */
    public function addOffer(\Crmp\AcquisitionBundle\Entity\Offer $offer)
    {
        $this->offers[] = $offer;

        return $this;
    }

    /**
     * Remove offer
     *
     * @param \Crmp\AcquisitionBundle\Entity\Offer $offer
     */
    public function removeOffer(\Crmp\AcquisitionBundle\Entity\Offer $offer)
    {
        $this->offers->removeElement($offer);
    }

    /**
     * Get offers
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getOffers()
    {
        return $this->offers;
    }

    /**
     * Set inquiredAt
     *
     * @param \DateTime $inquiredAt
     *
     * @return Inquiry
     */
    public function setInquiredAt($inquiredAt)
    {
        $this->inquiredAt = $inquiredAt;

        return $this;
    }

    /**
     * Get inquiredAt
     *
     * @return \DateTime
     */
    public function getInquiredAt()
    {
        return $this->inquiredAt;
    }

    /**
     * Set status
     *
     * @param integer $status
     *
     * @return Inquiry
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
        $map = Config::getChoices('acquisition.inquiry.status');

        return array_search($this->getStatus(), $map, true);
    }
}
