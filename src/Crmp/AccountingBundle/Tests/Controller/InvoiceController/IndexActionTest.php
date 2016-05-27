<?php

namespace Crmp\AccountingBundle\Tests\Controller\InvoiceController;


use Crmp\CrmBundle\Tests\Controller\AuthTestCase;

class IndexActionTest extends AuthTestCase
{
    public function testUserCanAccessTheList()
    {
        $client = $this->createAuthorizedUserClient('GET', 'invoice_index');

        $this->assertTrue($client->getResponse()->isSuccessful());
    }
}