<?php

namespace Crmp\CrmBundle\Tests\Controller\AddressController;


use Crmp\CrmBundle\Entity\Address;
use Crmp\CrmBundle\Tests\Controller\AuthTestCase;

class EditActionTest extends AuthTestCase
{
    public function testUserCanEditAnAddress()
    {
        /** @var Address $someAddress */
        $someAddress = $this->getRandomEntity('CrmpCrmBundle:Address');

        $this->assertInstanceOf('\\Crmp\\CrmBundle\\Entity\\Address', $someAddress);

        $routeParameters = ['id' => $someAddress->getId()];
        $client          = $this->createAuthorizedUserClient('GET', 'address_edit', $routeParameters);
        $response        = $client->getResponse();

        $this->assertTrue($response->isSuccessful());
        $this->assertContains($someAddress->getName(), $response->getContent());

        $this->assertRoute($client, 'address_edit', $routeParameters);
    }
}