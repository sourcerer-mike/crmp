<?php

namespace Crmp\AcquisitionBundle\Panel;


use Crmp\CrmBundle\Entity\Customer;
use Crmp\CrmBundle\Twig\AbstractPanel;
use Crmp\CrmBundle\Twig\PanelInterface;

class InquiryPanel extends AbstractPanel implements PanelInterface
{
    /**
     * Return a unique identifier among all known boardlets.
     *
     * @return string
     */
    public function getId()
    {
        return 'acquisition_inquiry_list';
    }

    /**
     * Return the name of this panel.
     *
     * @return string
     */
    public function getTitle()
    {
        return $this->container->get('translator')->trans('crmp.acquisition.inquiry.plural');
    }

    public function getData()
    {
        if ($this->data) {
            return (array) $this->data;
        }

        $this->data = $this->container->get('crmp.controller.render.parameters');
        $this->data['inquiries'] = [1];

        if ( ! isset( $this->data['customer'] ) || false == ($this->data['customer'] instanceof Customer)) {
            return $this->data;
        }

        /** @var Customer $customer */
        $customer = $this->data['customer'];
        $addressRepo = $this->container->get('doctrine')->getRepository('AcquisitionBundle:Inquiry');

        $this->data['inquiries'] = $addressRepo->findBy(
            [
                'customer' => $customer,
            ],
            null,
            10
        );

        return $this->data;
    }

    public function getTemplate()
    {
        return 'AcquisitionBundle:Customer:_panel-inquiry.html.twig';
    }


}