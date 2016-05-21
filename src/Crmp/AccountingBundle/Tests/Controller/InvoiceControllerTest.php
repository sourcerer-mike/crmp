<?php

namespace Crmp\AccountingBundle\Tests\Controller;

use Crmp\CrmBundle\Tests\Controller\AuthTestCase;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class InvoiceControllerTest extends AuthTestCase
{
    public function testUserCanAccessTheList()
    {
        $this->assertAvailableForUsers('invoice_index');
    }
}
