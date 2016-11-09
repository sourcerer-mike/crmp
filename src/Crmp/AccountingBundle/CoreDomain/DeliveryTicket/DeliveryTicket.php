<?php


namespace Crmp\AccountingBundle\CoreDomain\DeliveryTicket;

use Crmp\AcquisitionBundle\Entity\Contract;

/**
 * Delivery tickets
 *
 * Delivery tickets are the sum up of what has been delivered
 * and will be part of an invoice.
 * The delivery ticket helps keeping track of the work,
 * what has been finished
 * and how it has been solved.
 *
 * @package Crmp\AccountingBundle\CoreDomain\DeliveryTicket
 */
class DeliveryTicket
{
    /**
     * Relation to a contract
     *
     * Every ticket can be related to a contract.
     * The ticket either is the fulfillment
     * or just a part of the whole contract.
     *
     * Delivery tickets can exist without a contract
     * for support hours on the phone,
     * a license
     * or other minor stuff.
     *
     * @var Contract
     */
    protected $contract;
    /**
     * Subject what has been delivered
     *
     * The title of a ticket sums up the underlying work that has been done.
     * It it a line that might go straight into the output of invoices.
     *
     * @var string
     */
    protected $title;
    /**
     * Net value of the delivery
     *
     * Each delivery has its value.
     *
     * @var float
     */
    protected $value;

    /**
     * Relating contract
     *
     * Get the contract that relates to that ticket.
     *
     * @return Contract
     */
    public function getContract()
    {
        return $this->contract;
    }

    /**
     * Get the current subject.
     *
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Get the net value.
     *
     * @return float
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * Set the current contract.
     *
     * @param Contract|null $contract Related contract.
     */
    public function setContract(Contract $contract = null)
    {
        $this->contract = $contract;
    }

    /**
     * Set the current subject.
     *
     * @param string $title Sum up what has been done.
     */
    public function setTitle($title)
    {
        $this->title = $title;
    }

    /**
     * Set the net value of the ticket.
     *
     * @param float $netValue Net value of the delivered goods.
     */
    public function setValue($netValue)
    {
        $this->value = $netValue;
    }
}
