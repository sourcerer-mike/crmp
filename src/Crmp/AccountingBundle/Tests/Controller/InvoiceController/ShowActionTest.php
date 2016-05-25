<?php

namespace Crmp\AccountingBundle\Tests\Controller\InvoiceController;


use Crmp\AccountingBundle\Entity\Invoice;
use Crmp\CrmBundle\Tests\Controller\AuthTestCase;

class ShowActionTest extends AuthTestCase
{
    public function testUserCanAccessAnInvoice()
    {
        /** @var Invoice $someInvoice */
        $someInvoice = $this->getRandomEntity('CrmpAccountingBundle:Invoice');

        $this->assertInstanceOf('\\Crmp\\AccountingBundle\\Entity\\Invoice', $someInvoice);

        $client   = $this->createAuthorizedUserClient('GET', 'invoice_show', ['id' => $someInvoice->getId()]);
        $response = $client->getResponse();

        $this->assertTrue($response->isSuccessful());
        $this->assertContains($someInvoice->getCustomer()->getName(), $response->getContent());
    }
}