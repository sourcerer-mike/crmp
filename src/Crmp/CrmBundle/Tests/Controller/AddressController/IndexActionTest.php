<?php

namespace Crmp\CrmBundle\Tests\Controller\AddressController;


use Crmp\CrmBundle\Tests\Controller\AuthTestCase;

class IndexActionTest extends AuthTestCase
{
    public function testUserCanAccessTheList()
    {
        $client = $this->createAuthorizedUserClient('GET', 'address_index');

        $this->assertTrue($client->getResponse()->isSuccessful());
    }
}