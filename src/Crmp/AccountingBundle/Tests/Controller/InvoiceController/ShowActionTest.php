<?php

namespace Crmp\AccountingBundle\Tests\Controller\InvoiceController;


use Crmp\AccountingBundle\Controller\InvoiceController;
use Crmp\AccountingBundle\Entity\Invoice;
use Crmp\CrmBundle\Tests\Controller\AbstractShowActionTest;

class ShowActionTest extends AbstractShowActionTest
{
    public function testUserCanAccessAnInvoice()
    {
        $invoice = new Invoice();
        $invoice->setValue(14);

        $this->expectRenderingWith('CrmpAccountingBundle:Invoice:show.html.twig', ['invoice' => $invoice]);

        $this->controllerMock->showAction($invoice);
    }

    protected function setUp()
    {
        $this->controllerClass = InvoiceController::class;

        parent::setUp();
    }
}