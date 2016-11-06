<?php

namespace Crmp\AcquisitionBundle\Tests\Controller\OfferController;


use Crmp\AcquisitionBundle\Controller\OfferController;
use Crmp\AcquisitionBundle\CoreDomain\Inquiry\InquiryRepository;
use Crmp\AcquisitionBundle\CoreDomain\Offer\OfferRepository;
use Crmp\AcquisitionBundle\Entity\Inquiry;
use Crmp\AcquisitionBundle\Entity\Offer;
use Crmp\CrmBundle\CoreDomain\Customer\CustomerRepository;
use Crmp\CrmBundle\Entity\Customer;
use Crmp\CrmBundle\Tests\Controller\AbstractControllerTestCase;
use Symfony\Component\HttpFoundation\Request;

class IndexActionTest extends AbstractControllerTestCase
{
    protected $controllerClass = OfferController::class;

    public function testItCanFilterByCustomer()
    {
        $customerId       = mt_rand(42, 1337);
        $expectedCustomer = new Customer();
        $expectedCustomer->setName(uniqid());

        $expectedOffer = new Offer();
        $expectedOffer->setCustomer($expectedCustomer);

        $mock = $this->mockRepositoryService('crmp.customer.repository', CustomerRepository::class);

        $mock->expects($this->once())
             ->method('find')
             ->with($customerId)
             ->willReturn($expectedCustomer);

        $this->expectFindAllSimilar($expectedOffer);

        $this->controllerMock->indexAction(new Request(['customer' => $customerId]));
    }

    public function testItCanFilterByInquiry()
    {
        $inquiryId = mt_rand(42, 1337);
        $inquiry   = new Inquiry();
        $inquiry->setTitle(uniqid());

        $expectedOffer = new Offer();
        $expectedOffer->setInquiry($inquiry);

        $mock = $this->mockRepositoryService('crmp.inquiry.repository', InquiryRepository::class);

        $mock->expects($this->once())
             ->method('find')
             ->with($inquiryId)
             ->willReturn($inquiry);

        $this->expectFindAllSimilar($expectedOffer);

        $this->controllerMock->indexAction(new Request(['inquiry' => $inquiryId]));
    }

    public function testItListsCustomers()
    {
        $this->expectRenderingWith('CrmpAcquisitionBundle:Offer:index.html.twig');

        $this->expectFindAllSimilar(new Offer());

        $this->controllerMock->indexAction(new Request([]));
    }
}