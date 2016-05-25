<?php

namespace Crmp\AcquisitionBundle\Tests\Controller\OfferController;


use Crmp\CrmBundle\Tests\Controller\AuthTestCase;

class IndexActionTest extends AuthTestCase
{
    public function testUserCanAccessTheList()
    {
        $client = $this->createAuthorizedUserClient('GET', 'offer_index');

        $this->assertTrue($client->getResponse()->isSuccessful());
    }
}