<?php

namespace Crmp\AcquisitionBundle\Entity;

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
     * @ORM\ManyToOne(targetEntity="\Crmp\CrmBundle\Entity\Customer", inversedBy="inquiry")
     * @ORM\JoinColumn(name="customer_id", referencedColumnName="id")
     */
    protected $customer;


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
}
