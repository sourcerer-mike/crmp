<?php

namespace Crmp\AcquisitionBundle\Panel\Customer;

use Crmp\CrmBundle\Entity\Customer;
use Crmp\CrmBundle\Twig\AbstractPanel;
use Crmp\CrmBundle\Twig\PanelInterface;

class InquiryPanel extends AbstractPanel implements PanelInterface
{
    public function getData()
    {
        if ($this->data) {
            return (array) $this->data;
        }

        $this->data              = $this->container->get('crmp.controller.render.parameters');
        $this->data['inquiries'] = [];

        if (! isset($this->data['customer']) || false == ( $this->data['customer'] instanceof Customer )) {
            return $this->data;
        }

        /** @var Customer $customer */
        $customer    = $this->data['customer'];
        $addressRepo = $this->container->get('doctrine')->getRepository('CrmpAcquisitionBundle:Inquiry');

        $this->data['inquiries'] = $addressRepo->findBy(
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
        return 'acquisition_inquiry_list';
    }

    public function getTemplate()
    {
        return 'CrmpAcquisitionBundle:Customer:_panel-inquiry.html.twig';
    }

    /**
     * Return the name of this panel.
     *
     * @return string
     */
    public function getTitle()
    {
        return $this->container->get('translator')->trans('crmp_acquisition.inquiry.plural');
    }
}
