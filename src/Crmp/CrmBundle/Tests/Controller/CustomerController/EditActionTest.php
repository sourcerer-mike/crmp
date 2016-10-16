<?php

namespace Crmp\CrmBundle\Tests\Controller\CustomerController;


use Crmp\CrmBundle\Controller\CustomerController;
use Crmp\CrmBundle\Entity\Customer;
use Crmp\CrmBundle\Tests\Controller\AbstractControllerTestCase;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class EditActionTest
 *
 * @see     CustomerController::editAction()
 *
 * @package Crmp\CrmBundle\Tests\Controller\CustomerController
 */
class EditActionTest extends AbstractControllerTestCase
{
    public function setUp()
    {
        $this->controllerClass = CustomerController::class;

        parent::setUp();

        $this->controllerBuilder->setMethods(
            [
                'createDeleteForm',
                'createForm',
                'render',
            ]
        );
    }

    public function testCreatesEditFormForCustomer()
    {
        $customer = new Customer();
        $customer->setName('king customer');

        $controller = $this->controllerMock = $this->controllerBuilder->getMock();

        $this->createCreateFormMock()
             ->expects($this->atLeastOnce())
             ->method('isSubmitted')
             ->willReturn(false);

        $this->createDeleteFormMock();

        $this->expectRendering('customer', $customer, 'CrmpCrmBundle:Customer:edit.html.twig');

        /** @var CustomerController $controller */
        $controller->editAction($this->createMock(Request::class), $customer);
    }
}