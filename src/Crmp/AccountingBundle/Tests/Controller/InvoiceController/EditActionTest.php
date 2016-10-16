<?php

namespace Crmp\AccountingBundle\Tests\Controller\InvoiceController;


use Crmp\AccountingBundle\Controller\InvoiceController;
use Crmp\AccountingBundle\CoreDomain\InvoiceRepository;
use Crmp\AccountingBundle\Entity\Invoice;
use Crmp\CrmBundle\Tests\Controller\AbstractControllerTestCase;
use Symfony\Component\HttpFoundation\Request;

/**
 * Edit an invoice.
 *
 * @see InvoiceController::editAction()
 *
 * @package Crmp\CrmBundle\Tests\Controller\AddressController
 */
class EditActionTest extends AbstractControllerTestCase
{
    public function testCreatesEditFormForInvoice()
    {
        $invoice = new Invoice();
        $invoice->setValue(44);

        $controller = $this->controllerMock = $this->controllerBuilder->getMock();

        $this->createCreateFormMock()
             ->expects($this->atLeastOnce())
             ->method('isSubmitted')
             ->willReturn(false);

        $this->createDeleteFormMock();

        $this->expectRendering('invoice', $invoice, 'CrmpAccountingBundle:Invoice:edit.html.twig');

        /** @var InvoiceController $controller */
        $controller->editAction($this->createMock(Request::class), $invoice);
    }

    public function testItDelegatesSaveOperations()
    {
        $invoice = new Invoice();
        $invoice->setValue(44);

        $controller = $this->controllerMock = $this->controllerBuilder->getMock();

        $controller->expects($this->atLeastOnce())
                   ->method('get')
                   ->with('crmp.invoice.repository')
                   ->willReturn(
                       $repoMock = $this->createMock(InvoiceRepository::class)
                   );

        $repoMock->expects($this->once())
                 ->method('update')
                 ->with($invoice);


        $createFormMock = $this->createCreateFormMock();

        $createFormMock->expects($this->atLeastOnce())
                       ->method('isSubmitted')
                       ->willReturn(true);

        $createFormMock->expects($this->atLeastOnce())
                       ->method('isValid')
                       ->willReturn(true);

        /** @var InvoiceController $controller */
        $controller->editAction($this->createMock(Request::class), $invoice);
    }

    protected function setUp()
    {
        $this->controllerClass = InvoiceController::class;

        parent::setUp();

        $this->controllerBuilder->setMethods(
            [
                'createDeleteForm',
                'createForm',
                'render',
                'get',
                'getUser',
                'redirectToRoute',
            ]
        );

    }
}