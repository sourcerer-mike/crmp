<?php

namespace Crmp\AcquisitionBundle\Tests\Panel\Customer;

use Crmp\AcquisitionBundle\CoreDomain\Contract\ContractRepository;
use Crmp\AcquisitionBundle\CoreDomain\Inquiry\InquiryRepository;
use Crmp\AcquisitionBundle\CoreDomain\Offer\OfferRepository;
use Crmp\AcquisitionBundle\Entity\Contract;
use Crmp\AcquisitionBundle\Entity\Inquiry;
use Crmp\AcquisitionBundle\Entity\Offer;
use Crmp\AcquisitionBundle\Panel\Customer\ContractPanel;
use Crmp\AcquisitionBundle\Panel\Customer\InquiryPanel;
use Crmp\AcquisitionBundle\Panel\Customer\OfferPanel;
use Crmp\CrmBundle\Entity\Customer;
use Crmp\CrmBundle\Tests\Panels\AbstractPanelTestCase;
use Nelmio\Alice\Instances\Populator\Methods\Custom;

/**
 * OfferPanelTest
 *
 * @see OfferPanel
 *
 * @package Crmp\AcquisitionBundle\Tests\Panell\Dashboard
 */
class OfferPanelTest extends AbstractPanelTestCase
{
    public function testItGathersSomeOpenOffers()
    {
        $offer = new Offer();

        $customer = new Customer();
        $customer->setName(uniqid());

        $offer->setCustomer($customer);

        $expectedSet = new \ArrayObject([uniqid()]);

        $repo = $this->mockRepository(OfferRepository::class);

        $repo->expects($this->atLeastOnce())
             ->method('findAllSimilar')
             ->with($offer)
             ->willReturn($expectedSet);

        $panel = new OfferPanel($repo, new \ArrayObject(['customer' => $customer]));

        $this->assertArraySubset(['offers' => $expectedSet], $panel->getData());
    }

    public function testItReusesAlreadyGatheredData()
    {
        $offer = new Offer();
        $offer->setTitle(uniqid());

        $expectedSet = new \ArrayObject([uniqid()]);

        $repo = $this->mockRepository(OfferRepository::class);

        $repo->expects($this->never())
             ->method('findAllSimilar');

        $panel = new OfferPanel($repo, new \ArrayObject(['offers' => $expectedSet, 'customer' => new Customer()]));

        $this->assertArraySubset(['offers' => $expectedSet], (array) $panel->getData());
    }
}