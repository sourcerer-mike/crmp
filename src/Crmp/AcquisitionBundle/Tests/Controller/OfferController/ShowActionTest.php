<?php

namespace Crmp\AcquisitionBundle\Tests\Controller\OfferController;


use Crmp\AcquisitionBundle\Entity\Offer;
use Crmp\CrmBundle\Tests\Controller\AuthTestCase;

class ShowActionTest extends AuthTestCase
{
    public function testUserCanAccessTheList()
    {
        /** @var Offer $someOffer */
        $someOffer = $this->getRandomEntity('CrmpAcquisitionBundle:Offer');

        $this->assertInstanceOf('\\Crmp\\AcquisitionBundle\\Entity\\Offer', $someOffer);

        $client   = $this->createAuthorizedUserClient('GET', 'offer_show', ['id' => $someOffer->getId()]);
        $response = $client->getResponse();

        $this->assertTrue($response->isSuccessful());
        $this->assertContains($someOffer->getTitle(), $response->getContent());
    }
}