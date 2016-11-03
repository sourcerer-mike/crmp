<?php

namespace Crmp\AccountingBundle\Tests\Controller\InvoiceController;


use Crmp\AccountingBundle\Controller\InvoiceController;
use Crmp\AccountingBundle\CoreDomain\InvoiceRepository;
use Crmp\AccountingBundle\Entity\Invoice;
use Crmp\CrmBundle\CoreDomain\Customer\CustomerRepository;
use Crmp\CrmBundle\Entity\Customer;
use Crmp\CrmBundle\Tests\Controller\AbstractControllerTestCase;
use Symfony\Component\HttpFoundation\Request;

/**
 * IndexActionTest
 *
 * @see     InvoiceController::indexAction()
 *
 * @package Crmp\AccountingBundle\Tests\Controller\InvoiceController
 */
class IndexActionTest extends AbstractControllerTestCase
{
    protected $controllerClass = InvoiceController::class;

    /**
     * It allows filtering by customer.
     *
     * This depends on what the repository allows.
     *
     * @see InvoiceRepository::findAllSimilar()
     */
    public function testItAllowsFilteringByCustomer()
    {
        $invoice = new Invoice();
        $invoice->setCustomer($customer = new Customer());

        $customer->setName(uniqid());

        $customerRepository = $this->getMockBuilder(CustomerRepository::class)
                                   ->disableOriginalConstructor()
                                   ->setMethods(['find'])
                                   ->getMock();
        $customerRepository
            ->expects($this->once())
            ->method('find')
            ->with(42)
            ->willReturn($customer);

        $this->mockService('crmp.customer.repository', $customerRepository);

        $this->controllerMock->expects($this->once())->method('findAllSimilar')->with($invoice);

        $this->controllerMock->indexAction(new Request(['customer' => 42]));
    }

    public function testItRendersAllInvoices()
    {
        $this->expectRenderingWith('CrmpAccountingBundle:Invoice:index.html.twig');

        $this->controllerMock->expects($this->once())->method('findAllSimilar')->with(new Invoice());

        $this->controllerMock->indexAction(new Request([]));
    }
}
