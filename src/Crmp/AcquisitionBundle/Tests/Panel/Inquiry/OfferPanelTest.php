<?php

namespace Crmp\AcquisitionBundle\Tests\Panel\Inquiry;

use Crmp\AcquisitionBundle\CoreDomain\Offer\OfferRepository;
use Crmp\AcquisitionBundle\Entity\Inquiry;
use Crmp\AcquisitionBundle\Entity\Offer;
use Crmp\AcquisitionBundle\Panel\Inquiry\OfferPanel;
use Crmp\CrmBundle\Tests\Panels\AbstractPanelTestCase;

/**
 * OfferPanelTest
 *
 * @see     OfferPanel
 *
 * @package Crmp\AcquisitionBundle\Tests\Panell\Dashboard
 */
class OfferPanelTest extends AbstractPanelTestCase
{
    public function testItGathersSomeOpenOffers()
    {
        $offer = new Offer();

        $inquiry = new Inquiry();
        $inquiry->setNetValue(42);

        $offer->setInquiry($inquiry);

        $expectedSet = new \ArrayObject([uniqid()]);

        $repo = $this->mockRepository(OfferRepository::class);

        $repo->expects($this->atLeastOnce())
             ->method('findAllSimilar')
             ->with($offer)
             ->willReturn($expectedSet);

        $panel = new OfferPanel($repo, new \ArrayObject(['inquiry' => $inquiry]));

        $this->assertArraySubset(['offers' => $expectedSet], (array) $panel->getData());
    }

    public function testItReusesAlreadyGatheredData()
    {
        $offer = new Offer();
        $offer->setStatus(0);

        $expectedSet = new \ArrayObject([uniqid()]);

        $repo = $this->mockRepository(OfferRepository::class);

        $repo->expects($this->never())
             ->method('findAllSimilar');

        $panel = new OfferPanel($repo, new \ArrayObject(['offers' => $expectedSet]));

        $this->assertArraySubset(['offers' => $expectedSet], (array) $panel->getData());
    }
}