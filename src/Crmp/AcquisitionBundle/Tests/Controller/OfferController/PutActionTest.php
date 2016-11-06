<?php

namespace Crmp\AcquisitionBundle\Tests\Controller\OfferController;


use Crmp\AcquisitionBundle\Controller\OfferController;
use Crmp\AcquisitionBundle\CoreDomain\Offer\OfferRepository;
use Crmp\AcquisitionBundle\Entity\Offer;
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
class PutActionTest extends AbstractControllerTestCase
{
    protected $controllerClass = OfferController::class;
    /**
     * @var \PHPUnit_Framework_MockObject_MockObject|OfferController
     */
    protected $controllerMock;
    private   $mainView = 'CrmpAcquisitionBundle:Offer:show.html.twig';

    public function testDoesNothingWhenNoStatusGiven()
    {
        $offer = new Offer();
        $offer->setTitle(uniqid());

        $expectedStatus = mt_rand(42, 1337);

        $expectedOffer = clone $offer;
        $expectedOffer->setStatus($expectedStatus);

        $repoMock = $this->getMockBuilder(OfferRepository::class)
                         ->disableOriginalConstructor()
                         ->setMethods(['find', 'persist'])
                         ->getMock();

        $repoMock->expects($this->once())
                 ->method('find')
                 ->with(42)
                 ->willReturn($offer);

        $repoMock->expects($this->never())
                 ->method('persist')
                 ->with($expectedOffer);

        $this->controllerMock->expects($this->any())
                             ->method('getMainRepository')
                             ->willReturn($repoMock);

        $this->expectRedirectToRoute('crmp_acquisition_offer_show', ['id' => null]);

        $this->controllerMock->putAction(new Request(['id' => 42]));
    }

    public function testItErrorsWhenNoOfferFound()
    {
        $repoMock = $this->getMockBuilder(OfferRepository::class)
                         ->disableOriginalConstructor()
                         ->setMethods(['find'])
                         ->getMock();

        $repoMock->expects($this->once())
                 ->method('find')
                 ->with(42)
                 ->willReturn(null);

        $this->controllerMock->expects($this->any())
                             ->method('getMainRepository')
                             ->willReturn($repoMock);

        $response = $this->controllerMock->putAction(new Request(['id' => 42]));

        $this->assertEquals(500, $response->getStatusCode());
    }

    public function testItUpdatesTheStatusOfAnOffer()
    {
        $offer = new Offer();
        $offer->setTitle(uniqid());

        $expectedStatus = mt_rand(42, 1337);

        $expectedOffer = clone $offer;
        $expectedOffer->setStatus($expectedStatus);

        $repoMock = $this->getMockBuilder(OfferRepository::class)
                         ->disableOriginalConstructor()
                         ->setMethods(['find', 'persist'])
                         ->getMock();

        $repoMock->expects($this->once())
                 ->method('find')
                 ->with(42)
                 ->willReturn($offer);

        $repoMock->expects($this->once())
                 ->method('persist')
                 ->with($expectedOffer);

        $this->controllerMock->expects($this->any())
                             ->method('getMainRepository')
                             ->willReturn($repoMock);

        $this->expectRedirectToRoute('crmp_acquisition_offer_show', ['id' => null]);

        $this->controllerMock->putAction(new Request(['id' => 42, 'status' => $expectedStatus]));
    }
}