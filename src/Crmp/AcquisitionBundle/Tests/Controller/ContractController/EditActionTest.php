<?php

namespace Crmp\AcquisitionBundle\Tests\Controller\ContractController;


use Crmp\AcquisitionBundle\Entity\Contract;
use Crmp\CrmBundle\Tests\Controller\AuthTestCase;

class EditActionTest extends AuthTestCase
{
    public function testUserCanEditAnAddress()
    {
        /** @var Contract $someContract */
        $someContract = $this->getRandomEntity('CrmpAcquisitionBundle:Contract');

        $this->assertInstanceOf('\\Crmp\\AcquisitionBundle\\Entity\\Contract', $someContract);

        $routeParameters = ['id' => $someContract->getId()];
        $client          = $this->createAuthorizedUserClient('GET', 'crmp_acquisition_contract_edit', $routeParameters);
        $response        = $client->getResponse();

        $this->assertTrue($response->isSuccessful());
        $this->assertContains($someContract->getTitle(), $response->getContent());

        $this->assertRoute($client, 'crmp_acquisition_contract_edit', $routeParameters);
    }
}