<?php

namespace Crmp\CrmBundle\Tests\Controller\CustomerController;


use Crmp\CrmBundle\Entity\Customer;
use Crmp\CrmBundle\Tests\Controller\AuthTestCase;

class EditActionTest extends AuthTestCase
{
    public function testUserCanEditACustomer()
    {
        /** @var Customer $someCustomer */
        $someCustomer = $this->getRandomEntity('CrmpCrmBundle:Customer');

        $this->assertInstanceOf('\\Crmp\\CrmBundle\\Entity\\Customer', $someCustomer);

        $routeParameters = ['id' => $someCustomer->getId()];
        $client          = $this->createAuthorizedUserClient('GET', 'crmp_crm_customer_edit', $routeParameters);
        $response        = $client->getResponse();

        $this->assertTrue($response->isSuccessful());
        $this->assertContains($someCustomer->getName(), $response->getContent());

        $this->assertRoute($client, 'crmp_crm_customer_edit', $routeParameters);
    }
}