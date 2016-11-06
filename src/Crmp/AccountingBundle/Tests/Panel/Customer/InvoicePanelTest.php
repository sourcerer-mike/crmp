<?php


namespace Crmp\AccountingBundle\Tests\Panel\Customer;


use Crmp\AccountingBundle\CoreDomain\InvoiceRepository;
use Crmp\AccountingBundle\Entity\Invoice;
use Crmp\AccountingBundle\Panel\Customer\InvoicePanel;
use Crmp\CrmBundle\Entity\Customer;
use Crmp\CrmBundle\Tests\Panels\AbstractPanelTestCase;
use Doctrine\ORM\EntityRepository;

class InvoicePanelTest extends AbstractPanelTestCase
{
    public function testItHasATitle()
    {
        $this->assertEquals('crmp_accounting.invoice.plural', $this->createPanel()->getTitle());
    }

    public function testItHasAnId()
    {
        $this->assertEquals('crmp_accounting.customer.related_panel.invoices', $this->createPanel()->getId());
    }

    public function testItHasItsOwnTemplate()
    {
        $this->assertEquals(
            'CrmpAccountingBundle:Customer:_panel-invoice.html.twig',
            $this->createPanel()->getTemplate()
        );
    }

    public function testItLooksUpInvoicesForTheCurrentCustomer()
    {
        $customer = new Customer();
        $customer->setName(uniqid());

        $expectedInvoice = new Invoice();
        $expectedInvoice->setCustomer($customer);

        $repositoryMock = $this->expectFindAllSimilar(InvoiceRepository::class, $expectedInvoice);

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

    public function testItReusesCachedData()
    {
        $customer       = new Customer();
        $repositoryMock = $this->expectNotFindAllSimilar(InvoiceRepository::class);
        $invoicePanel   = new InvoicePanel(
            $repositoryMock,
            new \ArrayObject(
                [
                    'customer' => $customer,
                    // Provide the cached data => no need to fetch
                    'invoices' => 'nonsense',
                ]
            )
        );

        $this->assertArraySubset(['invoices' => 'nonsense'], (array) $invoicePanel->getData());
    }

    public function testItStopsWhenNoValidCustomerIsProvided()
    {
        $repositoryMock = $this->expectNotFindAllSimilar(InvoiceRepository::class);
        $invoicePanel   = new InvoicePanel(
            $repositoryMock,
            new \ArrayObject(
                [
                    'customer' => 'nonsense',
                ]
            )
        );

        $this->assertArraySubset(['invoices' => []], (array) $invoicePanel->getData());
    }

    /**
     * @return InvoicePanel
     */
    protected function createPanel()
    {
        return new InvoicePanel($this->mockRepository(InvoiceRepository::class), new \ArrayObject());
    }
}
