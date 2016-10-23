<?php

namespace Crmp\AcquisitionBundle\Panel\Dashboard;

use Crmp\AcquisitionBundle\Entity\Inquiry;
use Crmp\CrmBundle\Twig\AbstractPanel;
use Crmp\CrmBundle\Twig\PanelInterface;

/**
 * Dashboard panel about open offers.
 *
 * @package Crmp\AcquisitionBundle\Panel\Dashboard
 */
class InquiryPanel extends AbstractPanel implements PanelInterface
{
    /**
     * Gather undetermined offers.
     *
     * @return array
     */
    public function getData()
    {
        if ($this->data) {
            return $this->data;
        }

        $qb = $this->container->get('doctrine.orm.entity_manager')
                              ->createQueryBuilder();

        $qb->select('i')
           ->from(Inquiry::class, 'i')
           ->where('i.status = 0')
           ->setMaxResults(3);

        $this->data = [
            'inquiries' => $qb->getQuery()->getResult(),
        ];

        return $this->data;
    }

    /**
     * Return a unique identifier among all known boardlets.
     *
     * @return string
     */
    public function getId()
    {
        return 'dashboard_inquiry';
    }

    /**
     * Override default template.
     *
     * @return string
     */
    public function getTemplate()
    {
        return 'CrmpAcquisitionBundle:Inquiry:_panel-dashboard.html.twig';
    }

    /**
     * Return the name of this panel.
     *
     * @return string
     */
    public function getTitle()
    {
        return $this->container->get('translator')->trans('crmp_acquisition.offer.open');
    }

    /**
     * Not visible when no open offer is found.
     *
     * @return bool
     */
    public function isVisible()
    {
        $data = $this->getData();

        return (bool) $data['inquiries'];
    }
}
