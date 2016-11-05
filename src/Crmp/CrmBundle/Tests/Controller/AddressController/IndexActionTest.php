<?php

namespace Crmp\CrmBundle\Tests\Controller\AddressController;


use Crmp\CrmBundle\Controller\AddressController;
use Crmp\CrmBundle\CoreDomain\Customer\CustomerRepository;
use Crmp\CrmBundle\Entity\Address;
use Crmp\CrmBundle\Entity\Customer;
use Crmp\CrmBundle\Tests\Controller\AbstractControllerTestCase;
use Symfony\Component\HttpFoundation\Request;

class IndexActionTest extends AbstractControllerTestCase
{
    protected $controllerClass = AddressController::class;

    public function testItCanBeFilteredByCustomer()
    {
        $customerId = 42;
        $customer   = new Customer();
        $customer->setName(uniqid());


        // Build customer repo
        $customerRepo = $this->getMockBuilder(CustomerRepository::class)
                             ->disableOriginalConstructor()
                             ->setMethods(['find'])
                             ->getMock();

        $customerRepo->expects($this->once())
                     ->method('find')
                     ->with($customerId)
                     ->willReturn($customer);

        $this->mockService('crmp.customer.repository', $customerRepo);

        // Assert correct filter
        $expectedAddress = new Address();
        $expectedAddress->setCustomer($customer);

        $this->controllerMock->expects($this->once())
                             ->method('findAllSimilar')
                             ->with($expectedAddress)
                             ->willReturn([]);

        $this->controllerMock->indexAction(new Request(['customer' => $customerId]));
    }

    public function testItListsAddresses()
    {
        $address = new Address();
        $address->setName(uniqid());

        $expectedCollection = [$address];

        $this->controllerMock->expects($this->once())
                             ->method('findAllSimilar')
                             ->willReturn($expectedCollection);

        $this->expectRenderingWith('CrmpCrmBundle:Address:index.html.twig', ['addresses' => $expectedCollection]);

        $this->controllerMock->indexAction(new Request());
    }
}
