<?php

namespace Crmp\AccountingBundle\Entity;

/**
 * Delivery ticket
 *
 * @package Crmp\AccountingBundle\Entity
 */
class DeliveryTicket extends \Crmp\AccountingBundle\CoreDomain\DeliveryTicket\DeliveryTicket
{
    /**
     * Identifier
     *
     * @var int
     */
    protected $id;

    /**
     * Identifier to the ticket.
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }
}
