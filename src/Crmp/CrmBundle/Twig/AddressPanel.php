<?php

namespace Crmp\CrmBundle\Twig;

use Crmp\CrmBundle\Entity\Address;
use Crmp\CrmBundle\Entity\Customer;

/**
 * List of addresses for a customer.
 *
 * @package Crmp\CrmBundle\Twig
 */
class AddressPanel extends AbstractPanel implements PanelInterface
{
    /**
     * Gather all addresses for current customer.
     *
     * @return array|null|object
     */
    public function getData()
    {
        if (isset($this->data['addresses'])) {
            return (array) $this->data;
        }

        $this->data['addresses'] = [];

        if (! isset($this->data['customer']) || false == ($this->data['customer'] instanceof Customer)) {
            return $this->data;
        }

        $address = new Address();
        $address->setCustomer($this->data['customer']);

        $this->data['addresses'] = $this->repository->findAllSimilar($address);

        return $this->data;
    }

    /**
     * Return a unique identifier among all known boardlets.
     *
     * @return string
     */
    public function getId()
    {
        return 'crmp_crm.customer.panel.address';
    }

    /**
     * Override default template.
     *
     * @return string
     */
    public function getTemplate()
    {
        return 'CrmpCrmBundle::Customer/_panel-address.html.twig';
    }

    /**
     * Return the name of this boardlet.
     *
     * @return string
     */
    public function getTitle()
    {
        return 'crmp_crm.address.plural';
    }
}
