<?php

namespace Crmp\CrmBundle\Tests\Controller;

class CustomerControllerTest extends AuthTestCase
{
    public function testUserCanAccessTheList()
    {
        $this->assertAvailableForUsers('crmp_crm_customer_index');
    }
}
