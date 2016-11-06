<?php

namespace Crmp\AcquisitionBundle\Panel\Offer;

use Crmp\AcquisitionBundle\Entity\Contract;
use Crmp\AcquisitionBundle\Entity\Offer;
use Crmp\CrmBundle\Twig\AbstractPanel;
use Crmp\CrmBundle\Twig\PanelInterface;

/**
 * List offers in the single contract view.
 *
 * @package Crmp\AcquisitionBundle\Panel\Offer
 */
class ContractPanel extends AbstractPanel implements PanelInterface
{
    /**
     * Gather offers for current contract.
     *
     * @return array
     */
    public function getData()
    {
        if (isset($this->data['contracts'])) {
            // seems like already fetched => reuse cached data
            return $this->data->getArrayCopy();
        }

        $this->data['contracts'] = [];

        if (! isset($this->data['offer']) || false == ($this->data['offer'] instanceof Offer)) {
            return (array) $this->data;
        }

        $contract = new Contract();
        $contract->setOffer($this->data['offer']);

        $this->data['contracts'] = $this->repository->findAllSimilar($contract);

        return $this->data->getArrayCopy();
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
        return 'CrmpAcquisitionBundle:Offer:_panel-contract.html.twig';
    }

    /**
     * Return the name of this panel.
     *
     * @return string
     */
    public function getTitle()
    {
        return 'crmp_acquisition.contract.plural';
    }
}
