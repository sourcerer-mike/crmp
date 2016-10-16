<?php

namespace Crmp\AcquisitionBundle\Tests\Controller\OfferController;


use Crmp\AcquisitionBundle\Controller\OfferController;
use Crmp\AcquisitionBundle\Entity\Offer;
use Crmp\CrmBundle\Tests\Controller\AbstractShowActionTest;

class ShowActionTest extends AbstractShowActionTest
{
    protected function setUp()
    {
        $this->controllerClass = OfferController::class;
        parent::setUp();
    }

    public function testOfferWillBeRendered()
    {
        $offer = new Offer();
        $offer->setTitle('foo bar');
        $offer->setContent('some content');

        $this->expectRendering('offer', $offer, 'CrmpAcquisitionBundle:Offer:show.html.twig');

        $this->controllerMock->showAction($offer);
    }
}