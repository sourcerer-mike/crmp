<?php

namespace Crmp\AcquisitionBundle\Tests\Controller\OfferController;


use Crmp\AcquisitionBundle\Controller\OfferController;
use Crmp\AcquisitionBundle\CoreDomain\Offer\OfferRepository;
use Crmp\AcquisitionBundle\Entity\Offer;
use Crmp\CrmBundle\Tests\Controller\AbstractControllerTestCase;
use Symfony\Component\HttpFoundation\Request;

/**
 * Asserting correct edit actions on an offer.
 *
 * @see OfferController::editAction()
 *
 * @package Crmp\AcquisitionBundle\Tests\Controller\OfferController
 */
class EditActionTest extends AbstractControllerTestCase
{
    public function testCreatesEditFormForOffer()
    {
        $offer = new Offer();
        $offer->setTitle('the offer');
        $offer->setStatus(-1);
        $offer->setPrice(44);

        $controller = $this->controllerMock = $this->controllerBuilder->getMock();

        $this->createCreateFormMock()
             ->expects($this->atLeastOnce())
             ->method('isSubmitted')
             ->willReturn(false);

        $this->createDeleteFormMock();

        $this->expectRendering('offer', $offer, 'CrmpAcquisitionBundle:Offer:edit.html.twig');

        /** @var OfferController $controller */
        $controller->editAction($this->createMock(Request::class), $offer);
    }

    public function testItDelegatesSaveOperations()
    {
        $offer = new Offer();
        $offer->setPrice(44);
        $offer->setStatus(-14);
        $offer->setTitle('the offer');

        $controller = $this->controllerMock = $this->controllerBuilder->getMock();

        $controller->expects($this->atLeastOnce())
                   ->method('get')
                   ->with('crmp.offer.repository')
                   ->willReturn(
                       $repoMock = $this->createMock(OfferRepository::class)
                   );

        $repoMock->expects($this->once())
                 ->method('update')
                 ->with($offer);


        $createFormMock = $this->createCreateFormMock();

        $createFormMock->expects($this->atLeastOnce())
                       ->method('isSubmitted')
                       ->willReturn(true);

        $createFormMock->expects($this->atLeastOnce())
                       ->method('isValid')
                       ->willReturn(true);

        /** @var OfferController $controller */
        $controller->editAction($this->createMock(Request::class), $offer);
    }

    protected function setUp()
    {
        $this->controllerClass = OfferController::class;

        parent::setUp();

        $this->controllerBuilder->setMethods(
            [
                'createDeleteForm',
                'createForm',
                'render',
                'get',
                'getUser',
                'redirectToRoute',
            ]
        );
    }
}