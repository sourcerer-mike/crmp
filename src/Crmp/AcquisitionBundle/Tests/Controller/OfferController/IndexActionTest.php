<?php

namespace Crmp\AcquisitionBundle\Tests\Controller\OfferController;


use Crmp\AcquisitionBundle\Controller\OfferController;
use Crmp\AcquisitionBundle\CoreDomain\Inquiry\InquiryRepository;
use Crmp\AcquisitionBundle\CoreDomain\Offer\OfferRepository;
use Crmp\AcquisitionBundle\Entity\Inquiry;
use Crmp\AcquisitionBundle\Entity\Offer;
use Crmp\CrmBundle\Entity\Customer;
use Crmp\CrmBundle\Repository\CustomerRepository;
use Crmp\CrmBundle\Tests\Controller\AbstractControllerTestCase;
use Symfony\Component\HttpFoundation\Request;

class IndexActionTest extends AbstractControllerTestCase
{
    protected $controllerClass = OfferController::class;
    /**
     * @var \PHPUnit_Framework_MockObject_MockObject|OfferController
     */
    protected $controllerMock;

    public function testItCanFilterByCustomer()
    {
        $expectedOffer = new Offer();

        $expectedOffer->setCustomer($expectedCustomer = new Customer());

        $expectedCustomer->setName(uniqid());

        $customerRepository = $this->getMockBuilder(CustomerRepository::class)
                                  ->disableOriginalConstructor()
                                  ->setMethods(['find'])
                                  ->getMock();

        $customerRepository->expects($this->once())
                          ->method('find')
                          ->with(42)
                          ->willReturn($expectedCustomer);

        $offerRepository = $this->getMockBuilder(OfferRepository::class)
                                ->disableOriginalConstructor()
                                ->setMethods(['findSimilar'])
                                ->getMock();

        $this->mockService('crmp.customer.repository', $customerRepository);

        // Assert that there is no filter.
        $offerRepository->expects($this->once())
                        ->method('findSimilar')
                        ->with($expectedOffer);

        $this->mockService('crmp.offer.repository', $offerRepository);

        $this->controllerMock->indexAction(new Request(['customer' => 42]));
    }

    public function testItCanFilterByInquiry()
    {
        $expectedOffer = new Offer();

        $expectedOffer->setInquiry($expectedInquiry = new Inquiry());

        $expectedInquiry->setTitle(uniqid());

        $inquiryRepository = $this->getMockBuilder(InquiryRepository::class)
                                  ->disableOriginalConstructor()
                                  ->setMethods(['find'])
                                  ->getMock();

        $inquiryRepository->expects($this->once())
                          ->method('find')
                          ->with(42)
                          ->willReturn($expectedInquiry);

        $offerRepository = $this->getMockBuilder(OfferRepository::class)
                                ->disableOriginalConstructor()
                                ->setMethods(['findSimilar'])
                                ->getMock();

        $this->mockService('crmp.inquiry.repository', $inquiryRepository);

        // Assert that there is no filter.
        $offerRepository->expects($this->once())
                        ->method('findSimilar')
                        ->with($expectedOffer);

        $this->mockService('crmp.offer.repository', $offerRepository);

        $this->controllerMock->indexAction(new Request(['inquiry' => 42]));
    }

    public function testItListsAllOffers()
    {
        $offerRepository = $this->getMockBuilder(OfferRepository::class)
                                ->disableOriginalConstructor()
                                ->setMethods(['findSimilar'])
                                ->getMock();

        // Assert that there is no filter.
        $offerRepository->expects($this->once())
                        ->method('findSimilar')
                        ->with(new Offer());

        $this->mockService('crmp.offer.repository', $offerRepository);

        $this->controllerMock->indexAction($this->createMock(Request::class));
    }
}