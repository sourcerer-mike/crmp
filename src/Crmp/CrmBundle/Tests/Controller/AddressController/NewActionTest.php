<?php

namespace Crmp\CrmBundle\Tests\Controller\AddressController;

use Crmp\CrmBundle\Controller\AddressController;
use Crmp\CrmBundle\CoreDomain\Address\AddressRepository;
use Crmp\CrmBundle\CoreDomain\Customer\CustomerRepository;
use Crmp\CrmBundle\Entity\Address;
use Crmp\CrmBundle\Entity\Customer;
use Crmp\CrmBundle\Entity\User;
use Crmp\CrmBundle\Form\AddressType;
use Crmp\CrmBundle\Tests\Controller\AbstractControllerTestCase;
use Symfony\Component\HttpFoundation\Request;

class NewActionTest extends AbstractControllerTestCase
{
    protected $controllerClass = AddressController::class;

    public function testItSetsTheGivenCustomer()
    {
        $customerId = 42;
        $customer   = new Customer();
        $customer->setName(uniqid());

        $expectedAddress = new Address();
        $expectedAddress->setCustomer($customer);

        $customerRepository = $this->getMockBuilder(CustomerRepository::class)
                                   ->disableOriginalConstructor()
                                   ->setMethods(['find'])
                                   ->getMock();

        $customerRepository->expects($this->once())
                           ->method('find')
                           ->with($customerId)
                           ->willReturn($customer);

        $this->mockService('crmp.customer.repository', $customerRepository);

        $this->expectForm(AddressType::class, $expectedAddress);


        $this->controllerMock->newAction(new Request(['customer' => $customerId]));
    }

    public function testItShowsFormForNewAddress()
    {
        $this->expectForm(AddressType::class, new Address());

        $this->controllerMock->newAction(new Request());
    }

    public function testSavingAnAddressRedirectsToShow()
    {
        $form = $this->expectForm(AddressType::class, new Address());

        $form->expects($this->once())
             ->method('isValid')
             ->willReturn(true);

        $form->expects($this->once())
             ->method('isSubmitted')
             ->willReturn(true);

        $addressRepository = $this->getMockBuilder(AddressRepository::class)
                                  ->disableOriginalConstructor()
                                  ->setMethods(['persist'])
                                  ->getMock();

        $addressRepository->expects($this->once())
                          ->method('persist');

        $this->controllerMock->expects($this->once())
                             ->method('getMainRepository')
                             ->willReturn($addressRepository);

        $this->mockMethodGetUser();

        $this->expectRedirectToRoute(AddressController::ROUTE_SHOW, ['id' => null]);

        $this->controllerMock->newAction(new Request(['name' => uniqid()]));
    }
}