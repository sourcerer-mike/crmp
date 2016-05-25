<?php

namespace Crmp\AccountingBundle\Tests\Controller\InvoiceController;


use Crmp\AccountingBundle\Entity\Invoice;
use Crmp\CrmBundle\Tests\Controller\AuthTestCase;

class EditActionTest extends AuthTestCase
{
    public function testUserCanEditAnInvoice()
    {
        /** @var Invoice $someInvoice */
        $someInvoice = $this->getRandomEntity('CrmpAccountingBundle:Invoice');

        $this->assertInstanceOf('\\Crmp\\AccountingBundle\\Entity\\Invoice', $someInvoice);

        $routeParameters = ['id' => $someInvoice->getId()];
        $client          = $this->createAuthorizedUserClient('GET', 'invoice_edit', $routeParameters);
        $response        = $client->getResponse();

        $this->assertTrue($response->isSuccessful());
        $this->assertContains($someInvoice->getValue(), $response->getContent());

        $this->assertRoute($client, 'invoice_edit', $routeParameters);
    }
}