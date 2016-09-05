<?php

namespace Crmp\AcquisitionBundle\Tests\Controller\OfferController;

use Crmp\AcquisitionBundle\Controller\OfferController;
use Crmp\AcquisitionBundle\Entity\Offer;
use Crmp\CrmBundle\Tests\Controller\AuthTestCase;
use Symfony\Component\HttpFoundation\Request;

class DeleteActionTest extends AuthTestCase
{
    public function testItDeletesExistingEntities()
    {
        // stub offer
        $offer = new Offer(uniqid('stub_'));

        $offer->setTitle(uniqid());
        $offer->setContent(uniqid());
        $offer->setPrice(159753);

        // need service container => scaffold via client
        $client = $this->createAuthClient();

        // mock repository adapter
        $mock = $this->mockRepositoryAdapter($client->getContainer(), 'crmp_acquisition.adapter.offer');
        $mock->expects($this->atLeastOnce())->method('delete')->with($offer)->willReturnSelf();

        // mock form creation in target controller
        $mockedTarget = $this->mockDeleteFormController(OfferController::class, $client->getContainer());

        // test
        $mockedTarget->deleteAction(new Request(), $offer);
    }
}