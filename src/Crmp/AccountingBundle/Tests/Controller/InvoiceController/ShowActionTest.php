<?php

namespace Crmp\AccountingBundle\Tests\Controller\InvoiceController;


use Crmp\AccountingBundle\Controller\InvoiceController;
use Crmp\AccountingBundle\Entity\Invoice;
use Crmp\CrmBundle\Tests\Controller\AbstractShowActionTest;

class ShowActionTest extends AbstractShowActionTest
{
    protected function setUp()
    {
        $this->controllerClass = InvoiceController::class;

        parent::setUp();
    }

    public function testUserCanAccessAnInvoice()
    {

        $invoice = new Invoice();
        $invoice->setValue(14);

        $this->expectRendering('invoice', $invoice, 'CrmpAccountingBundle:Invoice:show.html.twig');

        $this->controllerMock->showAction($invoice);
    }
}