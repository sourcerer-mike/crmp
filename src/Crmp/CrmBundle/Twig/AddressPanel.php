<?php

namespace Crmp\CrmBundle\Twig;


use Crmp\CrmBundle\Entity\Customer;

class AddressPanel extends AbstractPanel implements PanelInterface
{
    public function getData()
    {
        if ($this->data) {
            return (array) $this->data;
        }

        $this->data = $this->container->get('crmp.controller.render.parameters');
        $this->data['addresses'] = [1];

        if ( ! isset( $this->data['customer'] ) || false == ($this->data['customer'] instanceof Customer)) {
            return $this->data;
        }

        /** @var Customer $customer */
        $customer = $this->data['customer'];
        $addressRepo = $this->container->get('doctrine')->getRepository('CrmBundle:Address');

        $this->data['addresses'] = $addressRepo->findBy(
            [
                'customer' => $customer,
            ],
            null,
            10
        );

        return $this->data;
    }

    public function getStyle()
    {
        return static::STYLE_INFO;
    }


    /**
     * Return a unique identifier among all known boardlets.
     *
     * @return string
     */
    public function getId()
    {
        return 'unique_id';
    }

    public function getTemplate()
    {
        return 'CrmBundle::Customer/_panel-address.html.twig';
    }

    /**
     * Return the name of this boardlet.
     *
     * @return string
     */
    public function getTitle()
    {
        return $this->container->get('translator')->trans('crmp.crm.address.plural');
    }


}