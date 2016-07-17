<?php

namespace Crmp\AcquisitionBundle\Tests\Controller\OfferController;


use Crmp\AcquisitionBundle\Entity\Offer;
use Crmp\CrmBundle\Tests\Controller\AuthTestCase;

class IndexActionTest extends AuthTestCase
{
    public function testItCanFilterByCustomer()
    {
        /** @var Offer $offer */
        $baseOffer = $this->getRandomEntity('CrmpAcquisitionBundle:Offer');

        // filter by customer
        $baseCustomerId = $baseOffer->getCustomer()->getId();
        $this->assertNotNull($baseCustomerId);
        $client = $this->createAuthorizedUserClient(
            'GET',
            'crmp_acquisition_offer_index',
            ['customer' => $baseCustomerId]
        );

        // assert every offer of the customer is shown
        $renderParams = $client->getContainer()->get('crmp.controller.render.parameters');

        $this->assertNotEmpty($renderParams['offers']);
        foreach ($renderParams['offers'] as $offer) {
            $this->assertEquals($baseCustomerId, $offer->getCustomer()->getId());
        }
    }

    public function testItCanFilterByInquiry()
    {
        $query = $this->queryEntity('CrmpAcquisitionBundle:Offer', 'offer');
        $someOffers = $query->where('offer.inquiry IS NOT NULL')
                       ->getQuery()
                       ->setMaxResults(10)
                       ->getArrayResult();

        $this->assertNotEmpty($someOffers);
        $offerData = $someOffers[array_rand($someOffers)];

        // get offer
        $this->assertNotNull($offerData['id']);
        /** @var Offer $offer */
        $offer = $this->findEntity('CrmpAcquisitionBundle:Offer', $offerData['id']);

        // make request
        $baseInquiryId = $offer->getInquiry()->getId();
        $this->assertNotNull($baseInquiryId);
        $client = $this->createAuthClient(
            'GET',
            'crmp_acquisition_offer_index',
            ['inquiry' => $baseInquiryId]
        );

        // assert every offer of the customer is shown
        $renderParams = $client->getContainer()->get('crmp.controller.render.parameters');

        $this->assertNotEmpty($renderParams['offers']);
        foreach ($renderParams['offers'] as $offer) {
            $this->assertEquals($baseInquiryId, $offer->getInquiry()->getId());
        }
    }

    public function testUserCanAccessTheList()
    {
        $client = $this->createAuthorizedUserClient('GET', 'crmp_acquisition_offer_index');

        $this->assertTrue($client->getResponse()->isSuccessful());
    }
}