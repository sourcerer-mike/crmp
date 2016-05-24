<?php

namespace Crmp\CrmBundle\Tests\Controller\AddressController;


use Crmp\CrmBundle\Entity\Address;
use Crmp\CrmBundle\Tests\Controller\AuthTestCase;

class ShowActionTest extends AuthTestCase
{
    public function testUserCanAccessTheList()
    {
        $client = static::createClient();

        $entityManager = $client->getContainer()->get('doctrine.orm.entity_manager');
        $query         = $entityManager->getRepository('CrmpCrmBundle:Address')->createQueryBuilder('address');

        /** @var Address $someAddress */
        $someAddress = $query->getQuery()->setMaxResults(1)->getOneOrNullResult();

        $this->assertInstanceOf('\\Crmp\\CrmBundle\\Entity\\Address', $someAddress);

        $client   = $this->createAuthorizedUserClient('GET', 'address_show', ['id' => $someAddress->getId()]);
        $response = $client->getResponse();

        $this->assertTrue($response->isSuccessful());
        $this->assertContains($someAddress->getName(), $response->getContent());
    }
}