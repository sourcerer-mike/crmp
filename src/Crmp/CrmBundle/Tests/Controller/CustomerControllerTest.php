<?php

namespace Crmp\CrmBundle\Tests\Controller;

/**
 * Customers
 *
 * Manage your customers.
 *
 * @package Crmp\CrmBundle\Tests\Controller
 */
class CustomerControllerTest extends AuthTestCase
{
    /**
     * Privileges as a user.
     *
     * As a user you are allowed to see the list of customers.
     */
    public function testUserCanAccessTheList()
    {
        $this->assertAvailableForUsers('crmp_crm_customer_index');
    }
}
