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

        $this->expectRendering('customer', $someCustomer, 'CrmpCrmBundle:Customer:show.html.twig');

        /** @var CustomerController $customerController */
        $this->controllerMock->showAction($someCustomer);
    }
}