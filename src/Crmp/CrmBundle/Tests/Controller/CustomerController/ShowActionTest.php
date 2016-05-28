<?php

namespace Crmp\CrmBundle\Tests\Controller\CustomerController;


use Crmp\CrmBundle\Entity\Customer;
use Crmp\CrmBundle\Tests\Controller\AuthTestCase;

class ShowActionTest extends AuthTestCase
{
    public function testUserCanLookAtACustomer()
    {
        /** @var Customer $someCustomer */
        $someCustomer = $this->getRandomEntity('CrmpCrmBundle:Customer');

        $this->assertInstanceOf('\\Crmp\\CrmBundle\\Entity\\Customer', $someCustomer);

        $client   = $this->createAuthorizedUserClient('GET', 'crmp_crm_customer_show', ['id' => $someCustomer->getId()]);
        $response = $client->getResponse();

        $this->assertTrue($response->isSuccessful());
        $this->assertContains($someCustomer->getName(), $response->getContent());
    }
}