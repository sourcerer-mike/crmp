<?php


namespace Crmp\CrmBundle\Tests\Controller;


use Symfony\Component\Form\Form;
use Symfony\Component\HttpFoundation\Response;

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

    /**
     * Check if the rendering will be called correctly.
     *
     * @deprecated 1.0.0 Use the more intuitive ::expectRenderingWith() method.
     *
     * @param $entityKey
     * @param $entity
     * @param $template
     */
    protected function expectRendering($entityKey, $entity, $template)
    {
        $self               = $this;
        $customerController = $this->controllerMock;

        $customerController->expects($this->once())->method('render')->willReturnCallback(
            function ($view, $parameters = array(), $response = null) use ($self, $entity, $template, $entityKey) {
                $self->assertEquals($template, $view);
                $self->assertEquals($entity, $parameters[$entityKey]);
            }
        );
    }

    /**
     * Check if the rendering will be called correctly.
     *
     * @see \Symfony\Bundle\FrameworkBundle\Controller\Controller::render()
     *
     * @param string   $expectedView       String what the view should be.
     * @param array    $expectedParameters Subset or complete array which data is required at last.
     * @param Response $expectedResponse   The complete expected response.
     */
    protected function expectRenderingWith($expectedView, $expectedParameters = array(), $expectedResponse = null)
    {
        $self = $this;

        $this->controllerMock->expects($this->once())->method('render')->willReturnCallback(
            function ($view, $parameters = array(), $response = null) use (
                $self,
                $expectedView,
                $expectedParameters,
                $expectedResponse
            ) {
                if ($expectedView) {
                    $self->assertEquals($expectedView, $view);
                }

                if ($expectedParameters) {
                    $self->assertArraySubset($expectedParameters, $parameters);
                }

                if ($response) {
                    $self->assertEquals($expectedResponse, $response);
                }
            }
        );
    }

    protected function setUp()
    {
        parent::setUp();

        $this->controllerBuilder = $this->getMockBuilder($this->controllerClass);
    }
}