<?php


namespace Crmp\AccountingBundle\Tests\Panel\Customer;


use Crmp\AccountingBundle\CoreDomain\InvoiceRepository;
use Crmp\AccountingBundle\Entity\Invoice;
use Crmp\AccountingBundle\Panel\Customer\InvoicePanel;
use Crmp\CrmBundle\Entity\Customer;
use Crmp\CrmBundle\Tests\Panels\AbstractPanelTestCase;

class InvoicePanelTest extends AbstractPanelTestCase
{
    public function testItLooksUpInvoicesForTheCurrentCustomer()
    {
        $customer = new Customer();
        $customer->setName(uniqid());

        $expectedInvoice = new Invoice();
        $expectedInvoice->setCustomer($customer);

        $repositoryMock = $this->getMockBuilder(InvoiceRepository::class)
                               ->disableOriginalConstructor()
                               ->setMethods(['findAllSimilar'])
                               ->getMock();

        $repositoryMock->expects($this->once())
                       ->method('findAllSimilar')
                       ->with($expectedInvoice);

        $invoicePanel = new InvoicePanel(
            $repositoryMock,
            new \ArrayObject(
                [
                    'customer' => $customer,
                ]
            )
        );

        $invoicePanel->getData();
    }
}
