<?php

namespace Crmp\AcquisitionBundle\Panel\Customer;

use Crmp\AcquisitionBundle\Entity\Inquiry;
use Crmp\CrmBundle\Entity\Customer;
use Crmp\CrmBundle\Twig\AbstractPanel;
use Crmp\CrmBundle\Twig\PanelInterface;

/**
 * Show inquiries for a customer.
 *
 * @package Crmp\AcquisitionBundle\Panel\Customer
 */
class InquiryPanel extends AbstractPanel implements PanelInterface
{
    /**
     * Gather all inquiries for current customer.
     *
     * @return array
     */
    public function getData()
    {
        if (isset($this->data['inquiries'])) {
            // seems like already fetched before => reuse cached data
            return $this->data->getArrayCopy();
        }

        $this->data['inquiries'] = [];

        if (! isset($this->data['customer']) || false == ( $this->data['customer'] instanceof Customer )) {
            return $this->data->getArrayCopy();
        }

        $inquiry = new Inquiry();
        $inquiry->setCustomer($this->data['customer']);

        $this->data['inquiries'] = $this->repository->findAllSimilar($inquiry);

        return $this->data->getArrayCopy();
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

    /**
     * Override default template.
     *
     * @return string
     */
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
