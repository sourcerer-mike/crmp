<?php

namespace Crmp\AccountingBundle\Tests\Controller\InvoiceController;

use Crmp\AccountingBundle\Controller\InvoiceController;
use Crmp\AccountingBundle\Entity\Invoice;
use Crmp\AccountingBundle\Form\InvoiceType;
use Crmp\CrmBundle\CoreDomain\Customer\CustomerRepository;
use Crmp\CrmBundle\Entity\Customer;
use Crmp\CrmBundle\Tests\Controller\AbstractControllerTestCase;
use Symfony\Component\HttpFoundation\Request;

class NewActionTest extends AbstractControllerTestCase
{
    protected $controllerClass = InvoiceController::class;

    public function testItAllowsSettingTheCustomerViaRequest()
    {
        $invoice = new Invoice();

        $customerId = mt_rand(42, 1337);

        $customer = new Customer();
        $customer->setName(uniqid());

        $invoice->setCustomer($customer);

        $customerRepository = $this->mockRepositoryService('crmp.customer.repository', CustomerRepository::class);

        $customerRepository->expects($this->once())
                           ->method('find')
                           ->with($customerId)
                           ->willReturn($customer);

        $this->expectForm(InvoiceType::class, $invoice);

        $this->controllerMock->newAction(new Request(['customer' => $customerId]));
    }

    public function testItAllowsSettingTheValueViaRequest()
    {
        $invoice = new Invoice();

        $value = mt_rand(42, 1337);

        $invoice->setValue((float) $value);

        $this->expectForm(InvoiceType::class, $invoice);

        $this->expectRenderingWith(
            'CrmpAccountingBundle:Invoice:new.html.twig',
            [
                'invoice' => $invoice,
            ]
        );

        $this->controllerMock->newAction(new Request(['value' => $value]));
    }

    public function testItCreatesTheInvoiceForm()
    {
        $inquiry = new Invoice();

        $formMock = $this->expectForm(InvoiceType::class, $inquiry);

        $expectedView = uniqid();
        $formMock->expects($this->once())
                 ->method('createView')
                 ->willReturn($expectedView);

        $this->expectRenderingWith(
            'CrmpAccountingBundle:Invoice:new.html.twig',
            [
                'form' => $expectedView,
            ]
        );

        $this->controllerMock->newAction(new Request());
    }
}