<?php

namespace Crmp\AcquisitionBundle\Tests\CoreDomain\Contract\ContractRepository;

use Crmp\AcquisitionBundle\CoreDomain\Contract\ContractRepository;
use Crmp\AcquisitionBundle\Entity\Contract;
use Crmp\AcquisitionBundle\Entity\Offer;
use Crmp\CrmBundle\Entity\Customer;
use Crmp\CrmBundle\Tests\CoreDomain\AbstractFindAllSimilarTestCase;

class FindAllSimilarTest extends AbstractFindAllSimilarTestCase
{
    public function testItCanFilterByCustomer()
    {
        $customer = new Customer();
        $customer->setName(uniqid());

        $contract = new Contract();
        $contract->setCustomer($customer);

        $this->assertFilteredBy('customer', $customer, $contract);
    }

    public function testItCanFilterByOffer()
    {
        $offer = new Offer();
        $offer->setTitle(uniqid());

        $contract = $this->createEntity();
        $contract->setOffer($offer);

        $this->assertFilteredBy('offer', $offer, $contract);
    }

    protected function createEntity()
    {
        return new Contract();
    }

    /**
     * Get the current class name.
     *
     * @return string
     */
    protected function getRepositoryClassName()
    {
        return ContractRepository::class;
    }
}