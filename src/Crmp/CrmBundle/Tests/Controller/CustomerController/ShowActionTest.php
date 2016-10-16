<?php

namespace Crmp\CrmBundle\Tests\Controller\CustomerController;


use Crmp\CrmBundle\Controller\CustomerController;
use Crmp\CrmBundle\Entity\Customer;
use Crmp\CrmBundle\Tests\Controller\AbstractShowActionTest;

class ShowActionTest extends AbstractShowActionTest
{
    public function setUp()
    {
        $this->controllerClass = CustomerController::class;

        parent::setUp();
    }


    public function testCustomerWillBeRendered()
    {
        /** @var Customer $someCustomer */
        $someCustomer = new Customer();
        $someCustomer->setName('John Doe');

        $this->assertInstanceOf('\\Crmp\\CrmBundle\\Entity\\Customer', $someCustomer);

        $self               = $this;
        $customerController = $this->controllerMock;

        $customerController->expects($this->once())->method('render')->willReturnCallback(
            function () use ($self, $someCustomer) {
                $args = func_get_args();

                $self->assertEquals('CrmpCrmBundle:Customer:show.html.twig', $args[0]);
                $self->assertEquals($someCustomer, $args[1]['customer']);
            }
        );

        /** @var CustomerController $customerController */
        $customerController->showAction($someCustomer);
    }
}