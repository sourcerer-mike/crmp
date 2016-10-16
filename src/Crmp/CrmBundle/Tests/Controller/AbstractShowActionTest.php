<?php


namespace Crmp\CrmBundle\Tests\Controller;


use Symfony\Component\Form\Form;
use Symfony\Component\Form\FormBuilder;

abstract class AbstractShowActionTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Mock of the customer controller.
     *
     * @var \PHPUnit_Framework_MockObject_MockBuilder
     */
    protected $controller;

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
    protected $controllerMock;

    protected $controllerClass = '';

    protected function setUp()
    {
        $this->controller = $this->getMockBuilder($this->controllerClass);

        $this->controllerMock = $this->controller->setMethods(
            ['createDeleteForm', 'createFormBuilder', 'render']
        )->getMock();

        $this->controllerMock->expects($this->any())->method('createDeleteForm')->willReturn(
            $this->createMock(Form::class)
        );

        $this->controllerMock->expects($this->atLeastOnce())->method('createFormBuilder')->willReturn(
            $this->createMock(FormBuilder::class)
        );

        parent::setUp();
    }
}