<?php


namespace Crmp\CrmBundle\Tests\Controller;


use Symfony\Component\Form\Form;

abstract class AbstractControllerTestCase extends \PHPUnit_Framework_TestCase
{
    /**
     * Mock of the customer controller.
     *
     * @var \PHPUnit_Framework_MockObject_MockBuilder
     */
    protected $controllerBuilder;

    /**
     * Class name of the test subject.
     *
     * @var string
     */
    protected $controllerClass = '';

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

    protected function expectRendering($entityKey, $entity, $template)
    {
        $self               = $this;
        $customerController = $this->controllerMock;

        $customerController->expects($this->once())->method('render')->willReturnCallback(
            function () use ($self, $entity, $template, $entityKey) {
                $args = func_get_args();

                $self->assertEquals($template, $args[0]);
                $self->assertEquals($entity, $args[1][$entityKey]);
            }
        );
    }

    protected function createCreateFormMock()
    {
        $this->controllerMock->expects($this->any())->method('createForm')->willReturn(
            $formMock = $this->createMock(Form::class)
        );

        return $formMock;
    }

    protected function createDeleteFormMock()
    {
        $this->controllerMock->expects($this->any())->method('createDeleteForm')->willReturn(
            $deleteFormMock = $this->createMock(Form::class)
        );

        return $deleteFormMock;
    }

    protected function setUp()
    {
        parent::setUp();

        $this->controllerBuilder = $this->getMockBuilder($this->controllerClass);
    }
}