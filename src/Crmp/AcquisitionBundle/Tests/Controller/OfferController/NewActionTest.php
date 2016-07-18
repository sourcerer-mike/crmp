<?php

namespace Crmp\AcquisitionBundle\Tests\Controller\OfferController;


use Crmp\AcquisitionBundle\Entity\Offer;
use Crmp\AcquisitionBundle\Form\OfferType;
use Crmp\CrmBundle\Tests\Controller\AuthTestCase;

class NewActionTest extends AuthTestCase
{
    public function testCreateNewOffer()
    {
        $client = $this->createAuthClient('GET', 'crmp_acquisition_offer_new');

        $data = [
            'title'    => 'UnitTestForm',
            'customer' => $this->getRandomEntity('CrmpCrmBundle:Customer')->getId(),
            'price'    => mt_rand(100, 900) * 10,
            'content'  => static::createClient()->getContainer()->get('hautelook_alice.faker')->text,
        ];

        $client->submit(
            $client->getCrawler()->filter('form')->form(),
            [
                'offer' => $data,
            ]
        );

        $this->assertTrue($client->getResponse()->isRedirection());

        $client->followRedirect();

        $params = $client->getContainer()->get('crmp.controller.render.parameters');

        /** @var Offer $offer */
        $this->assertInstanceOf(Offer::class, $params['offer']);
        $offer = $params['offer'];

        $this->assertEquals($offer->getTitle(), $data['title']);
        $this->assertEquals($offer->getCustomer()->getId(), $data['customer']);
        $this->assertEquals($offer->getPrice(), $data['price']);
        $this->assertEquals($offer->getContent(), $data['content']);
    }

    public function testItIsPossibleToPresetACustomer()
    {
        $customerId = $this->getRandomEntity('CrmpCrmBundle:Customer')->getId();

        $client = $this->createAuthClient('GET', 'crmp_acquisition_offer_new', ['customer' => $customerId]);

        $selected = $client->getCrawler()->filterXPath(
            "//select[@id='offer_customer']/option[@selected='selected']/@value"
        );

        $this->assertEquals($customerId, $selected->first()->text());
    }

    public function testItIsPossibleToPresetAnInquiry()
    {
        $inquiryId = $this->getRandomEntity('CrmpAcquisitionBundle:Inquiry')->getId();

        $client = $this->createAuthClient('GET', 'crmp_acquisition_offer_new', ['inquiry' => $inquiryId]);

        $selected = $client->getCrawler()->filterXPath(
            "//select[@id='offer_inquiry']/option[@selected='selected']/@value"
        );

        $this->assertEquals($inquiryId, $selected->first()->text());
    }
}