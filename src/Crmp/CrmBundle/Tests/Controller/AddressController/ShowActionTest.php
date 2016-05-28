<?php

namespace Crmp\CrmBundle\Tests\Controller\AddressController;


use Crmp\CrmBundle\Entity\Address;
use Crmp\CrmBundle\Tests\Controller\AuthTestCase;

class ShowActionTest extends AuthTestCase
{
    public function testUserCanAccessTheList()
    {
        /** @var Address $someAddress */
        $someAddress = $this->getRandomEntity('CrmpCrmBundle:Address');

        $this->assertInstanceOf('\\Crmp\\CrmBundle\\Entity\\Address', $someAddress);

        $client   = $this->createAuthorizedUserClient('GET', 'crmp_crm_address_show', ['id' => $someAddress->getId()]);
        $response = $client->getResponse();

        $this->assertTrue($response->isSuccessful());
        $this->assertContains($someAddress->getName(), $response->getContent());
    }
}