<?php

namespace Crmp\AcquisitionBundle\Entity;

use Crmp\CrmBundle\Entity\Config;
use Doctrine\ORM\Mapping as ORM;

/**
 * Inquiry
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
     * @var string
     *
     * @ORM\Column(name="title", type="string", length=255)
     */
    private $title;

    /**
     * @var string
     *
     * @ORM\Column(name="netValue", type="decimal", precision=5, scale=0)
     */
    private $netValue;

    /**
     * @var string
     *
     * @ORM\Column(name="content", type="text", nullable=true)
     */
    private $content;

    /**
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
     * @ORM\Column(type="integer", name="status")
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
