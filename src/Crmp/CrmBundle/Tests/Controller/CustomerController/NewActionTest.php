<?php

namespace Crmp\CrmBundle\Tests\Controller\CustomerController;

use Crmp\CrmBundle\Controller\AddressController;
use Crmp\CrmBundle\Controller\CustomerController;
use Crmp\CrmBundle\CoreDomain\Address\AddressRepository;
use Crmp\CrmBundle\CoreDomain\Customer\CustomerRepository;
use Crmp\CrmBundle\Entity\Address;
use Crmp\CrmBundle\Entity\Customer;
use Crmp\CrmBundle\Entity\User;
use Crmp\CrmBundle\Form\AddressType;
use Crmp\CrmBundle\Form\CustomerType;
use Crmp\CrmBundle\Tests\Controller\AbstractControllerTestCase;
use Symfony\Component\HttpFoundation\Request;

class NewActionTest extends AbstractControllerTestCase
{
    protected $controllerClass = CustomerController::class;

    public function testItShowsFormForNewAddress()
    {
        $this->expectForm(CustomerType::class, new Customer());

        $this->controllerMock->newAction(new Request());
    }

    public function testSavingAnAddressRedirectsToShow()
    {
        $form = $this->expectForm(CustomerType::class, new Customer());

        $form->expects($this->once())
             ->method('isValid')
             ->willReturn(true);

        $form->expects($this->once())
             ->method('isSubmitted')
             ->willReturn(true);

        $repository = $this->getMockBuilder(CustomerRepository::class)
                           ->disableOriginalConstructor()
                           ->setMethods(['persist'])
                           ->getMock();

        $repository->expects($this->once())
                   ->method('persist');

        $this->controllerMock->expects($this->once())
                             ->method('getMainRepository')
                             ->willReturn($repository);

        $this->expectRedirectToRoute(CustomerController::ROUTE_SHOW, ['id' => null]);

        $this->controllerMock->newAction(new Request(['name' => uniqid()]));
    }
}