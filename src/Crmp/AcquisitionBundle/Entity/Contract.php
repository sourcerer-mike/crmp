<?php

namespace Crmp\AcquisitionBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Contract
 *
 * A customer may contract you with or without an offer.
 * This part helps you to keep track of your duties and apply some controlling.
 *
 * @ORM\Table(name="contract")
 * @ORM\Entity(repositoryClass="Crmp\AcquisitionBundle\Repository\ContractRepository")
 */
class Contract
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
     * Subject of the contract.
     *
     * The subject shall explain it's content within one sentence
     * to provide a better and simple overview in lists.
     * It is at most 255 characters long.
     *
     * @var string
     *
     * @ORM\Column(name="title", type="string", length=255)
     */
    private $title;

    /**
     * Contract value.
     *
     * The total amount of money without taxes is stored
     * to enable some controlling in CRMP
     * or create invoices and more.
     * It can be a number with four decimals and a total of 16 digits.
     *
     * @var string
     *
     * @ORM\Column(name="value", type="decimal", precision=16, scale=4)
     */
    private $value;

    /**
     * Agreement about deliverable.
     *
     * What shall be delivered is written down in the content,
     * so that customer and contractor know what they have to do.
     * It can be a long text as long as your database can bare.
     *
     * @var string
     *
     * @ORM\Column(name="content", type="text")
     */
    private $content;

    /**
     * @ORM\ManyToOne(targetEntity="Offer", inversedBy="contracts")
     * @ORM\JoinColumn(name="contract_id", referencedColumnName="id")
     */
    private $offer;

    /**
     * @ORM\ManyToOne(targetEntity="Crmp\CrmBundle\Entity\Customer")
     * @ORM\JoinColumn(name="customer_id", referencedColumnName="id")
     */
    private $customer;

    /**
     * @return \Crmp\CrmBundle\Entity\Customer
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
     * Set title
     *
     * @param string $title
     *
     * @return Contract
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
     * Set value
     *
     * @param string $value
     *
     * @return Contract
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
     * Set content
     *
     * @param string $content
     *
     * @return Contract
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
     * Set offer
     *
     * @param \Crmp\AcquisitionBundle\Entity\Offer $offer
     *
     * @return Contract
     */
    public function setOffer(\Crmp\AcquisitionBundle\Entity\Offer $offer = null)
    {
        $this->offer = $offer;

        return $this;
    }

    /**
     * Get offer
     *
     * @return \Crmp\AcquisitionBundle\Entity\Offer
     */
    public function getOffer()
    {
        return $this->offer;
    }

    /**
     * Set customer
     *
     * @param \Crmp\CrmBundle\Entity\Customer $customer
     *
     * @return Contract
     */
    public function setCustomer(\Crmp\CrmBundle\Entity\Customer $customer = null)
    {
        $this->customer = $customer;

        return $this;
    }
}
