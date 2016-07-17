<?php

namespace Crmp\AcquisitionBundle\Tests\Controller\OfferController;


use Crmp\AcquisitionBundle\Entity\Offer;
use Crmp\CrmBundle\Tests\Controller\AuthTestCase;
use Symfony\Component\Validator\Constraints\NotNull;

class ShowActionTest extends AuthTestCase
{
    public function testUserCanAccessTheList()
    {
        /** @var Offer $someOffer */
        $someOffer = $this->getRandomEntity('CrmpAcquisitionBundle:Offer');

        $this->assertInstanceOf('\\Crmp\\AcquisitionBundle\\Entity\\Offer', $someOffer);

        $client   = $this->createAuthorizedUserClient('GET', 'crmp_acquisition_offer_show', ['id' => $someOffer->getId()]);
        $response = $client->getResponse();

        $this->assertTrue($response->isSuccessful());
        $this->assertContains($someOffer->getTitle(), $response->getContent());
    }

    public function testRelatedCustomerIsShownWithOffer()
    {
        $em = static::createClient()->getContainer()->get('doctrine.orm.entity_manager');
        $repo = $em->getRepository('CrmpAcquisitionBundle:Offer');

        $all = $repo->createQueryBuilder('offer')
            ->where('offer.customer IS NOT NULL')
            ->setMaxResults(5)
            ->getQuery()
            ->getArrayResult();

        $this->assertNotEmpty($all);
        $offerData = $all[array_rand($all)];

        $this->assertArrayHasKey('id', $offerData);
        $offerId = $offerData['id'];

        // load offer
        $this->assertNotEmpty($offerId);
        $offer = $repo->find($offerId);
        $this->assertInstanceOf('\\Crmp\\AcquisitionBundle\\Entity\\Offer', $offer);

        // get customer
        $customer = $offer->getCustomer();
        $this->assertNotNull($customer);

        // request
        $client = $this->createAuthorizedUserClient('GET', 'crmp_acquisition_offer_show', ['id' => $offerId]);

        $this->assertContains($customer->getName(), $client->getResponse()->getContent());
    }
}