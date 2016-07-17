<?php

namespace Crmp\CrmBundle\Twig;

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
        if ($this->data) {
            return (array) $this->data;
        }

        $this->data              = $this->container->get('crmp.controller.render.parameters');
        $this->data['addresses'] = [1];

        if (! isset($this->data['customer']) || false == ($this->data['customer'] instanceof Customer)) {
            return $this->data;
        }

        /** @var Customer $customer */
        $customer    = $this->data['customer'];
        $addressRepo = $this->container->get('doctrine')->getRepository('CrmpCrmBundle:Address');

        $this->data['addresses'] = $addressRepo->findBy(
            [
                'customer' => $customer,
            ],
            null,
            10
        );

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
        return $this->container->get('translator')->trans('crmp_crm.address.plural');
    }
}
