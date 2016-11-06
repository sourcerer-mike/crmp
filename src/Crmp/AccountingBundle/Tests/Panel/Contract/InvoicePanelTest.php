<?php


namespace Crmp\AccountingBundle\Tests\Panel\Contract;


use Crmp\AccountingBundle\CoreDomain\InvoiceRepository;
use Crmp\AccountingBundle\Entity\Invoice;
use Crmp\AccountingBundle\Panel\Contract\InvoicePanel;
use Crmp\AcquisitionBundle\Entity\Contract;
use Crmp\CrmBundle\Tests\Panels\AbstractPanelTestCase;

class InvoicePanelTest extends AbstractPanelTestCase
{
    public function testItHasATitle()
    {
        $this->assertEquals('crmp_accounting.invoice.plural', $this->createPanel()->getTitle());
    }

    public function testItHasAnId()
    {
        $this->assertEquals('crmp_accounting.contract.related_panel.invoices', $this->createPanel()->getId());
    }

    public function testItHasItsOwnTemplate()
    {
        $this->assertEquals(
            'CrmpAccountingBundle:Contract:_panel-invoice.html.twig',
            $this->createPanel()->getTemplate()
        );
    }

    public function testItLooksUpInvoicesForTheCurrentContract()
    {
        $contract = new Contract();
        $contract->setTitle(uniqid());

        $expectedInvoice = new Invoice();
        $expectedInvoice->setContract($contract);

        $repositoryMock = $this->expectFindAllSimilar(InvoiceRepository::class, $expectedInvoice);

        $invoicePanel = new InvoicePanel(
            $repositoryMock,
            new \ArrayObject(
                [
                    'contract' => $contract,
                ]
            )
        );

        $invoicePanel->getData();
    }

    public function testItReusesCachedData()
    {
        $contract       = new Contract();
        $repositoryMock = $this->expectNotFindAllSimilar(InvoiceRepository::class);
        $invoicePanel   = new InvoicePanel(
            $repositoryMock,
            new \ArrayObject(
                [
                    'contract' => $contract,
                    // Provide the cached data => no need to fetch
                    'invoices' => 'nonsense',
                ]
            )
        );

        $this->assertArraySubset(['invoices' => 'nonsense'], (array) $invoicePanel->getData());
    }

    public function testItStopsWhenNoValidContractIsProvided()
    {
        $repositoryMock = $this->expectNotFindAllSimilar(InvoiceRepository::class);
        $invoicePanel   = new InvoicePanel(
            $repositoryMock,
            new \ArrayObject(
                [
                    'contract' => 'nonsense',
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
