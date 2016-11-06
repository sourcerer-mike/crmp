<?php

namespace Crmp\AcquisitionBundle\Tests\Panel\Offer;

use Crmp\AcquisitionBundle\CoreDomain\Contract\ContractRepository;
use Crmp\AcquisitionBundle\Entity\Contract;
use Crmp\AcquisitionBundle\Entity\Offer;
use Crmp\AcquisitionBundle\Panel\Offer\ContractPanel;
use Crmp\CrmBundle\Tests\Panels\AbstractPanelTestCase;

/**
 * OfferPanelTest
 *
 * @see     ContractPanel
 *
 * @package Crmp\AcquisitionBundle\Tests\Panell\Dashboard
 */
class ContractPanelTest extends AbstractPanelTestCase
{
    public function testItGathersSomeOpenContracts()
    {
        $contract = new Contract();

        $offer = new Offer();
        $offer->setTitle(uniqid());

        $contract->setOffer($offer);

        $expectedSet = new \ArrayObject([uniqid()]);

        $repo = $this->mockRepository(ContractRepository::class);

        $repo->expects($this->atLeastOnce())
             ->method('findAllSimilar')
             ->with($contract)
             ->willReturn($expectedSet);

        $panel = new ContractPanel($repo, new \ArrayObject(['offer' => $offer]));

        $this->assertArraySubset(['contracts' => $expectedSet], (array) $panel->getData());
    }

    public function testItHasAnId()
    {
        $panel = new ContractPanel();
        $this->assertEquals('acquisition_contract_list', $panel->getId());
    }

    public function testItHasAnOwnTemplate()
    {
        $panel = new ContractPanel();
        $this->assertEquals('CrmpAcquisitionBundle:Offer:_panel-contract.html.twig', $panel->getTemplate());
    }

    public function testItHasAnTitle()
    {
        $panel = new ContractPanel();
        $this->assertEquals('crmp_acquisition.contract.plural', $panel->getTitle());
    }

    public function testItReusesAlreadyGatheredData()
    {
        $offer = new Offer();
        $offer->setStatus(0);

        $expectedSet = new \ArrayObject([uniqid()]);

        $repo = $this->mockRepository(ContractRepository::class);

        $repo->expects($this->never())
             ->method('findAllSimilar');

        $panel = new ContractPanel($repo, new \ArrayObject(['contracts' => $expectedSet, 'offer' => new Offer()]));

        $this->assertArraySubset(['contracts' => $expectedSet], (array) $panel->getData());
    }
}