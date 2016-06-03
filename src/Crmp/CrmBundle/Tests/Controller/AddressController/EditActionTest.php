<?php

namespace Crmp\CrmBundle\Tests\Controller\AddressController;


use Crmp\CrmBundle\Entity\Address;
use Crmp\CrmBundle\Tests\Controller\AuthTestCase;

/**
 * Edit an address.
 *
 * Open a single address and click the edit link.
 *
 * @package Crmp\CrmBundle\Tests\Controller\AddressController
 */
class EditActionTest extends AuthTestCase
{
    /**
     * Users are authorized to edit an address.
     *
     * Every user can edit an address.
     */
    public function testUserCanEditAnAddress()
    {
        /** @var Address $someAddress */
        $someAddress = $this->getRandomEntity('CrmpCrmBundle:Address');

        $this->assertInstanceOf('\\Crmp\\CrmBundle\\Entity\\Address', $someAddress);

        $routeParameters = ['id' => $someAddress->getId()];
        $client          = $this->createAuthorizedUserClient('GET', 'crmp_crm_address_edit', $routeParameters);
        $response        = $client->getResponse();

        $this->assertTrue($response->isSuccessful());
        $this->assertContains($someAddress->getName(), $response->getContent());

        $this->assertRoute($client, 'crmp_crm_address_edit', $routeParameters);
    }
}