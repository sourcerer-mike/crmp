<?php

namespace Crmp\CrmBundle\Tests\Controller;

class CustomerControllerTest extends AuthTestCase
{
    public function testUserCanAccessTheList()
    {
        $this->assertAvailableForUsers('customer_index');
    }
}
