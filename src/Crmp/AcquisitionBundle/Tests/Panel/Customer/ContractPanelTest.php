<?php

namespace Crmp\AcquisitionBundle\Tests\Panel\Customer;

use Crmp\AcquisitionBundle\CoreDomain\Contract\ContractRepository;
use Crmp\AcquisitionBundle\Entity\Contract;
use Crmp\AcquisitionBundle\Entity\Offer;
use Crmp\AcquisitionBundle\Panel\Customer\ContractPanel;
use Crmp\CrmBundle\Entity\Customer;
use Crmp\CrmBundle\Tests\Panels\AbstractPanelTestCase;

/**
 * OfferPanelTest
 *
 * @see     OfferPanel
 *
 * @package Crmp\AcquisitionBundle\Tests\Panell\Dashboard
 */
class ContractPanelTest extends AbstractPanelTestCase
{
    public function testItGathersSomeOpenOffers()
    {
        $contract = new Contract();

        $customer = new Customer();
        $customer->setName(uniqid());

        $contract->setCustomer($customer);

        $expectedSet = new \ArrayObject([uniqid()]);

        $repo = $this->mockRepository(ContractRepository::class);

        $repo->expects($this->atLeastOnce())
             ->method('findAllSimilar')
             ->with($contract)
             ->willReturn($expectedSet);

        $panel = new ContractPanel($repo, new \ArrayObject(['customer' => $customer]));

        $this->assertArraySubset(['contracts' => $expectedSet], $panel->getData());
    }

    public function testItReusesAlreadyGatheredData()
    {
        $offer = new Offer();
        $offer->setStatus(0);

        $expectedSet = new \ArrayObject([uniqid()]);

        $repo = $this->mockRepository(ContractRepository::class);

        $repo->expects($this->never())
             ->method('findAllSimilar');

        $panel = new ContractPanel($repo, new \ArrayObject(['contracts' => $expectedSet]));

        $this->assertArraySubset(['contracts' => $expectedSet], (array) $panel->getData());
    }
}