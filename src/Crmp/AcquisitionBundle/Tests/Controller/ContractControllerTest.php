<?php

namespace Crmp\AcquisitionBundle\Tests\Controller;

use Crmp\CrmBundle\Tests\Controller\AuthTestCase;

class ContractControllerTest extends AuthTestCase
{
    public function testUserCanAccessTheList()
    {
        $this->assertAvailableForUsers('crmp_acquisition_contract_index');
    }
}
