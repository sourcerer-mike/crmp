<?php

namespace Crmp\AcquisitionBundle\Tests\Controller\OfferController;


use Crmp\AcquisitionBundle\Entity\Offer;
use Crmp\CrmBundle\Tests\Controller\AuthTestCase;

class EditActionTest extends AuthTestCase
{
    public function testOfferCanBeChanged()
    {
        /** @var Offer $offer */
        $offer  = $this->getRandomEntity('CrmpAcquisitionBundle:Offer');
        $client = $this->createAuthClient('GET', 'crmp_acquisition_offer_edit', ['id' => $offer->getId()]);

        $generator = $client->getContainer()->get('hautelook_alice.faker');

        $newTitle = $generator->title;
        $this->assertNotEquals($newTitle, $offer->getTitle());

        $newContent = $generator->text;
        $this->assertNotEquals($newContent, $offer->getContent());

        $client->submit(
            $client->getCrawler()->filterXPath("//form[@name='offer']")->form(),
            [
                'offer' => [
                    'title'   => $newTitle,
                    'content' => $newContent,
                ],
            ]
        );

        $this->assertTrue($client->getResponse()->isRedirection());

        $client->followRedirect();

        $params = $client->getContainer()->get('crmp.controller.render.parameters');

        /** @var Offer $offer */
        $offer = $params['offer'];

        $this->assertEquals($newTitle, $offer->getTitle());
        $this->assertEquals($newContent, $offer->getContent());
    }

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