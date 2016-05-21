<?php

namespace Crmp\AcquisitionBundle\Tests\Controller;

use Crmp\CrmBundle\Tests\Controller\AuthTestCase;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class ContractControllerTest extends AuthTestCase
{
    public function testUserCanAccessTheList()
    {
        $this->assertAvailableForUsers('contract_index');
    }
}
