<?php


namespace Crmp\AccountingBundle\Tests\CoreDomain\DeliveryTicket;


use Crmp\AccountingBundle\CoreDomain\DeliveryTicket\DeliveryTicket;
use Crmp\AccountingBundle\Entity\Invoice;
use Crmp\AcquisitionBundle\Entity\Contract;

class DeliveryTicketTest extends \PHPUnit_Framework_TestCase
{
    public function testItCanBeConnectedToAContract()
    {
        $ticket = new DeliveryTicket();

        $contract = new Contract();
        $contract->setTitle(uniqid());

        $ticket->setContract($contract);

        $this->assertEquals($contract, $ticket->getContract());
    }

    public function testItDoesHaveAValueAsFloatNumber()
    {
        $ticket = new DeliveryTicket();

        $netValue = mt_rand(42, 1337) / 100;

        $ticket->setValue($netValue);

        $this->assertEquals($netValue, $ticket->getValue());
    }

    public function testItDoesNotNeedToHaveAContract()
    {
        $ticket = new DeliveryTicket();

        $ticket->setContract(null);

        $this->assertNull($ticket->getContract());
    }

    public function testItHasATitle()
    {
        $ticket = new DeliveryTicket();

        $expectedTitle = uniqid();

        $ticket->setTitle($expectedTitle);

        $this->assertEquals($expectedTitle, $ticket->getTitle());
    }

    public function testItMustHaveAnInvoice()
    {
        $ticket = new DeliveryTicket();

        $value = mt_rand(42, 1337);

        $invoice = new Invoice();
        $invoice->setValue($value);

        $ticket->setInvoice($invoice);

        $this->assertEquals($invoice, $ticket->getInvoice());
    }
}