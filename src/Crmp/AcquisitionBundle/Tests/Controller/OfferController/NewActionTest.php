<?php

namespace Crmp\AcquisitionBundle\Tests\Controller\OfferController;


use Crmp\AcquisitionBundle\Controller\OfferController;
use Crmp\AcquisitionBundle\CoreDomain\Inquiry\InquiryRepository;
use Crmp\AcquisitionBundle\CoreDomain\Offer\OfferRepository;
use Crmp\AcquisitionBundle\Entity\Inquiry;
use Crmp\AcquisitionBundle\Entity\Offer;
use Crmp\AcquisitionBundle\Form\OfferType;
use Crmp\CrmBundle\CoreDomain\Customer\CustomerRepository;
use Crmp\CrmBundle\Entity\Customer;
use Crmp\CrmBundle\Tests\Controller\AbstractControllerTestCase;
use Symfony\Component\HttpFoundation\Request;

/**
 * Asserting that creating an offer works correct.
 *
 * @see     OfferController::newAction()
 *
 * @package Crmp\AcquisitionBundle\Tests\Controller\OfferController
 *
 */
class NewActionTest extends AbstractControllerTestCase
{
    protected $controllerClass = OfferController::class;
    /**
     * @var \PHPUnit_Framework_MockObject_MockObject|OfferController
     */
    protected $controllerMock;
    private   $mainView = 'CrmpAcquisitionBundle:Offer:new.html.twig';

    public function getMockedMethods()
    {
        $mockedMethods = parent::getMockedMethods();

        $mockedMethods[] = 'get';

        return $mockedMethods;
    }

    public function testItFetchesQueriedCustomers()
    {
        $expectedOffer = new Offer();
        $expectedOffer->setCustomer($customer = new Customer());

        $customer->setName(uniqid());

        $repoMock = $this->getMockBuilder(CustomerRepository::class)
                         ->disableOriginalConstructor()
                         ->setMethods(['find'])
                         ->getMock();

        $repoMock->expects($this->atLeastOnce())
                 ->method('find')
                 ->with(42)
                 ->willReturn($customer);

        $this->mockService('crmp.customer.repository', $repoMock);

        $this->expectForm(OfferType::class, $expectedOffer);

        $this->expectRenderingWith(
            $this->mainView,
            [
                'offer' => $expectedOffer,
            ]
        );

        /** @var Request $request */
        $request = new Request(['customer' => 42]);

        $this->controllerMock->newAction($request);
    }

    public function testItFetchesQueriedInquiries()
    {
        $expectedOffer = new Offer();
        $expectedOffer->setInquiry($inquiry = new Inquiry());

        $inquiry->setTitle(uniqid());

        $repoMock = $this->getMockBuilder(InquiryRepository::class)
                         ->disableOriginalConstructor()
                         ->setMethods(['find'])
                         ->getMock();

        $repoMock->expects($this->atLeastOnce())
                 ->method('find')
                 ->with(42)
                 ->willReturn($inquiry);

        $this->mockService('crmp.inquiry.repository', $repoMock);

        $this->expectForm(OfferType::class, $expectedOffer);

        $this->expectRenderingWith(
            $this->mainView,
            [
                'offer' => $expectedOffer,
            ]
        );

        /** @var Request $request */
        $request = new Request(['inquiry' => 42]);

        $this->controllerMock->newAction($request);
    }

    public function testItShowsTheFormForNewOffers()
    {
        $expectedOffer = new Offer();

        $this->expectForm(OfferType::class, $expectedOffer);

        $this->expectRenderingWith(
            'CrmpAcquisitionBundle:Offer:new.html.twig',
            [
                'offer' => $expectedOffer,
            ]
        );

        /** @var OfferController $this ->controllerMock */
        $this->controllerMock->newAction($this->createMock(Request::class));
    }

    public function testItStoresNewOffersInRepository()
    {
        $offerRepoMock = $this->getMockBuilder(OfferRepository::class)
                              ->disableOriginalConstructor()
                              ->setMethods(['update'])
                              ->getMock();

        $offerRepoMock->expects($this->once())
                      ->method('update')
                      ->with(new Offer());

        $this->mockService('crmp.offer.repository', $offerRepoMock);

        $this->expectRedirectToRoute('crmp_acquisition_offer_show', array('id' => null));

        $formMock = $this->expectForm(OfferType::class, new Offer());
        $formMock->expects($this->once())
                 ->method('isSubmitted')
                 ->willReturn(true);

        $formMock->expects($this->once())
                 ->method('isValid')
                 ->willReturn(true);

        $this->controllerMock->newAction($this->createMock(Request::class));
    }

    public function testItUsesTheCustomerFromInquiries()
    {
        $expectedOffer = new Offer();
        $expectedOffer->setInquiry($inquiry = new Inquiry());

        $inquiry->setTitle(uniqid());
        $inquiry->setCustomer($customer = new Customer());

        $customer->setName(uniqid());

        $expectedOffer->setCustomer($customer);

        $repoMock = $this->getMockBuilder(InquiryRepository::class)
                         ->disableOriginalConstructor()
                         ->setMethods(['find'])
                         ->getMock();

        $repoMock->expects($this->atLeastOnce())
                 ->method('find')
                 ->with(42)
                 ->willReturn($inquiry);

        $this->mockService('crmp.inquiry.repository', $repoMock);

        $this->expectForm(OfferType::class, $expectedOffer);

        $this->expectRenderingWith(
            $this->mainView,
            [
                'offer' => $expectedOffer,
            ]
        );

        /** @var Request $request */
        $request = new Request(['inquiry' => 42]);

        $this->controllerMock->newAction($request);
    }

    protected function mockService($serviceName, $return = false)
    {
        $getMethod = $this->controllerMock
            ->expects($this->once())
            ->method('get')
            ->with($serviceName);

        if (false !== $return) {
            return $getMethod->willReturn($return);
        }

        return $getMethod->willReturnSelf();
    }
}