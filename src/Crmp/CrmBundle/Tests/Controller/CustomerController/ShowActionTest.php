<?php

namespace Crmp\CrmBundle\Tests\Controller\CustomerController;


use Crmp\CrmBundle\Controller\CustomerController;
use Crmp\CrmBundle\Entity\Customer;
use Crmp\CrmBundle\Tests\Controller\AuthTestCase;
use Symfony\Component\Form\Form;
use Symfony\Component\Form\FormBuilder;
use Symfony\Component\Form\FormConfigBuilder;
use Symfony\Component\HttpFoundation\Response;

class ShowActionTest extends AuthTestCase
{
    /**
     * Mock of the customer controller.
     *
     * @var \PHPUnit_Framework_MockObject_MockBuilder
     */
    protected $customerController;

    /**
     * CustomerController mocking some functions.
     *
     * Disabled in ::setUp method:
     *
     * - ::createForm
     * - ::deleteForm
     * - ::render
     *
     * @var \PHPUnit_Framework_MockObject_MockObject
     */
    protected $customerControllerMock;

    protected function setUp()
    {
        $this->customerController = $this->getMockBuilder(CustomerController::class);

        $this->customerControllerMock = $this->customerController->setMethods(
            ['createDeleteForm', 'createFormBuilder', 'render']
        )->getMock();

        $this->customerControllerMock->expects($this->any())->method('createDeleteForm')->willReturn(
            $this->createMock(Form::class)
        );

        $this->customerControllerMock->expects($this->atLeastOnce())->method('createFormBuilder')->willReturn(
            $this->createMock(FormBuilder::class)
        );

        parent::setUp();
    }

    public function testCustomerWillBeRendered()
    {
        /** @var Customer $someCustomer */
        $someCustomer = new Customer();
        $someCustomer->setName('John Doe');

        $this->assertInstanceOf('\\Crmp\\CrmBundle\\Entity\\Customer', $someCustomer);

        $self               = $this;
        $customerController = $this->customerControllerMock;

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