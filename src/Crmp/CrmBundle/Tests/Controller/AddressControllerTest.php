<?php

namespace Crmp\CrmBundle\Tests\Controller;

class AddressControllerTest extends AuthTestCase
{
    public function testUserCanAccessTheList()
    {
        $this->assertAvailableForUsers('address_index');
    }
}
