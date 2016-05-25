<?php

namespace Crmp\AcquisitionBundle\Tests\Controller\ContractController;


use Crmp\CrmBundle\Tests\Controller\AuthTestCase;

class IndexActionTest extends AuthTestCase
{
    public function testUserCanAccessTheList()
    {
        $client = $this->createAuthorizedUserClient('GET', 'contract_index');

        $this->assertTrue($client->getResponse()->isSuccessful());
    }
}