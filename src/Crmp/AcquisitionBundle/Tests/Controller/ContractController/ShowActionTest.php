<?php

namespace Crmp\AcquisitionBundle\Tests\Controller\ContractController;


use Crmp\AcquisitionBundle\Entity\Contract;
use Crmp\CrmBundle\Tests\Controller\AuthTestCase;

class ShowActionTest extends AuthTestCase
{
    public function testUserCanAccessTheList()
    {
        /** @var Contract $someContract */
        $someContract = $this->getRandomEntity('CrmpAcquisitionBundle:Contract');

        $this->assertInstanceOf('\\Crmp\\AcquisitionBundle\\Entity\\Contract', $someContract);

        $client   = $this->createAuthorizedUserClient('GET', 'crmp_acquisition_contract_show', ['id' => $someContract->getId()]);
        $response = $client->getResponse();

        $this->assertTrue($response->isSuccessful());
        $this->assertContains($someContract->getTitle(), $response->getContent());
    }
}