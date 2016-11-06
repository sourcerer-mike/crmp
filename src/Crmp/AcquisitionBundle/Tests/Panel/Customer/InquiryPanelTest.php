<?php

namespace Crmp\AcquisitionBundle\Tests\Panel\Customer;

use Crmp\AcquisitionBundle\CoreDomain\Contract\ContractRepository;
use Crmp\AcquisitionBundle\CoreDomain\Inquiry\InquiryRepository;
use Crmp\AcquisitionBundle\Entity\Contract;
use Crmp\AcquisitionBundle\Entity\Inquiry;
use Crmp\AcquisitionBundle\Entity\Offer;
use Crmp\AcquisitionBundle\Panel\Customer\ContractPanel;
use Crmp\AcquisitionBundle\Panel\Customer\InquiryPanel;
use Crmp\CrmBundle\Entity\Customer;
use Crmp\CrmBundle\Tests\Panels\AbstractPanelTestCase;

/**
 * OfferPanelTest
 *
 * @see     OfferPanel
 *
 * @package Crmp\AcquisitionBundle\Tests\Panell\Dashboard
 */
class InquiryPanelTest extends AbstractPanelTestCase
{
    public function testItGathersSomeOpenOffers()
    {
        $inquiry = new Inquiry();

        $customer = new Customer();
        $customer->setName(uniqid());

        $inquiry->setCustomer($customer);

        $expectedSet = new \ArrayObject([uniqid()]);

        $repo = $this->mockRepository(InquiryRepository::class);

        $repo->expects($this->atLeastOnce())
             ->method('findAllSimilar')
             ->with($inquiry)
             ->willReturn($expectedSet);

        $panel = new InquiryPanel($repo, new \ArrayObject(['customer' => $customer]));

        $this->assertArraySubset(['inquiries' => $expectedSet], $panel->getData());
    }

    public function testItReusesAlreadyGatheredData()
    {
        $inquiry = new Inquiry();
        $inquiry->setTitle(uniqid());

        $expectedSet = new \ArrayObject([uniqid()]);

        $repo = $this->mockRepository(InquiryRepository::class);

        $repo->expects($this->never())
             ->method('findAllSimilar');

        $panel = new ContractPanel($repo, new \ArrayObject(['inquiries' => $expectedSet]));

        $this->assertArraySubset(['inquiries' => $expectedSet], (array) $panel->getData());
    }
}