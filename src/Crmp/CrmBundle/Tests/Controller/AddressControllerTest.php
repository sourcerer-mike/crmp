<?php

namespace Crmp\CrmBundle\Tests\Controller;

/**
 * Addresses
 *
 * Manage your addresses.
 *
 * @package Crmp\CrmBundle\Tests\Controller
 */
class AddressControllerTest extends AuthTestCase
{
    /**
     * @group internal
     */
    public function testUserCanAccessTheList()
    {
        $this->assertAvailableForUsers('crmp_crm_address_index');
    }
}
