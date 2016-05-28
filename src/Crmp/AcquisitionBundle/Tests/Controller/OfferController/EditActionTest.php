<?php

namespace Crmp\AcquisitionBundle\Tests\Controller\OfferController;


use Crmp\AcquisitionBundle\Entity\Offer;
use Crmp\CrmBundle\Tests\Controller\AuthTestCase;

class EditActionTest extends AuthTestCase
{
    public function testUserCanEditAnAddress()
    {
        /** @var Offer $someOffer */
        $someOffer = $this->getRandomEntity('CrmpAcquisitionBundle:Offer');

        $this->assertInstanceOf('\\Crmp\\AcquisitionBundle\\Entity\\Offer', $someOffer);

        $routeParameters = ['id' => $someOffer->getId()];
        $client          = $this->createAuthorizedUserClient('GET', 'crmp_acquisition_offer_edit', $routeParameters);
        $response        = $client->getResponse();

        $this->assertTrue($response->isSuccessful());
        $this->assertContains($someOffer->getTitle(), $response->getContent());

        $this->assertRoute($client, 'crmp_acquisition_offer_edit', $routeParameters);
    }
}