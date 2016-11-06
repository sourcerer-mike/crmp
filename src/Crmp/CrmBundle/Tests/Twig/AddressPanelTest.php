<?php


namespace Crmp\CrmBundle\Tests\Twig;


use Crmp\CrmBundle\CoreDomain\Address\AddressRepository;
use Crmp\CrmBundle\Entity\Address;
use Crmp\CrmBundle\Entity\Customer;
use Crmp\CrmBundle\Tests\Panels\AbstractPanelTestCase;
use Crmp\CrmBundle\Twig\AddressPanel;

class AddressPanelTest extends AbstractPanelTestCase
{
    public function testItHasATitle()
    {
        $this->assertEquals('crmp_crm.address.plural', $this->createPanel()->getTitle());
    }

    public function testItHasAnId()
    {
        $this->assertEquals('crmp_crm.customer.panel.address', $this->createPanel()->getId());
    }

    public function testItHasItsOwnTemplate()
    {
        $this->assertEquals(
            'CrmpCrmBundle::Customer/_panel-address.html.twig',
            $this->createPanel()->getTemplate()
        );
    }

    public function testItLooksUpInvoicesForTheCurrentCustomer()
    {
        $customer = new Customer();
        $customer->setName(uniqid());

        $expectedAddress = new Address();
        $expectedAddress->setCustomer($customer);

        $repositoryMock = $this->expectFindAllSimilar(AddressRepository::class, $expectedAddress);

        $addressPanel = new AddressPanel(
            $repositoryMock,
            new \ArrayObject(
                [
                    'customer' => $customer,
                ]
            )
        );

        $addressPanel->getData();
    }

    public function testItReusesCachedData()
    {
        $customer       = new Customer();
        $repositoryMock = $this->expectNotFindAllSimilar(AddressRepository::class);
        $addressPanel   = new AddressPanel(
            $repositoryMock,
            new \ArrayObject(
                [
                    'customer' => $customer,
                    // Provide the cached data => no need to fetch
                    'addresses' => 'nonsense',
                ]
            )
        );

        $this->assertArraySubset(['addresses' => 'nonsense'], (array) $addressPanel->getData());
    }

    public function testItStopsWhenNoValidCustomerIsProvided()
    {
        $repositoryMock = $this->expectNotFindAllSimilar(AddressRepository::class);
        $addressPanel   = new AddressPanel(
            $repositoryMock,
            new \ArrayObject(
                [
                    'customer' => 'nonsense',
                ]
            )
        );

        $this->assertArraySubset(['addresses' => []], (array) $addressPanel->getData());
    }

    /**
     * @return AddressPanel
     */
    protected function createPanel()
    {
        return new AddressPanel($this->mockRepository(AddressRepository::class), new \ArrayObject());
    }
}
