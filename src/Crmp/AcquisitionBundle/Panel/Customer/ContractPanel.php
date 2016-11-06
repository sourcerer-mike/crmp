<?php

namespace Crmp\AcquisitionBundle\Panel\Customer;

use Crmp\AcquisitionBundle\Entity\Contract;
use Crmp\CrmBundle\Entity\Customer;
use Crmp\CrmBundle\Twig\AbstractPanel;
use Crmp\CrmBundle\Twig\PanelInterface;

/**
 * Show contracts for a single customer.
 *
 * @package Crmp\AcquisitionBundle\Panel\Customer
 */
class ContractPanel extends AbstractPanel implements PanelInterface
{
    /**
     * Gather contracts for current customer.
     *
     * @return array
     */
    public function getData()
    {
        if (isset($this->data['contracts'])) {
            // seems like already pushed before => reuse cached data
            return $this->data->getArrayCopy();
        }

        $this->data['contracts'] = [];

        if (! isset($this->data['customer']) || false == ( $this->data['customer'] instanceof Customer )) {
            return (array) $this->data;
        }

        $contract = new Contract();
        $contract->setCustomer($this->data['customer']);

        $this->data['contracts'] = $this->repository->findAllSimilar($contract);

        return (array) $this->data->getArrayCopy();
    }

    /**
     * Return a unique identifier among all known boardlets.
     *
     * @return string
     */
    public function getId()
    {
        return 'acquisition_contract_list';
    }

    /**
     * Override default template.
     *
     * @return string
     */
    public function getTemplate()
    {
        return 'CrmpAcquisitionBundle:Customer:_panel-contract.html.twig';
    }

    /**
     * Return the name of this panel.
     *
     * @return string
     */
    public function getTitle()
    {
        return $this->container->get('translator')->trans('crmp_acquisition.contract.plural');
    }
}
