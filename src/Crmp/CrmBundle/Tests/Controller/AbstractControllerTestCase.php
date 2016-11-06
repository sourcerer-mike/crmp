<?php


namespace Crmp\CrmBundle\Tests\Controller;


use Crmp\CrmBundle\Entity\User;
use Symfony\Component\Form\AbstractType;
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
    private   $serviceMap;

    public function getMockedMethods()
    {
        return [
            'createDeleteForm',
            'createForm',
            'findAllSimilar',
            'get',
            'getUser',
            'getMainRepository',
            'redirectToRoute',
            'render',
        ];
    }

    /**
     * Mock the ::createForm method.
     *
     * @deprecated Use ::expectForm instead.
     *
     * @return \PHPUnit_Framework_MockObject_MockObject
     */
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
     * Assertion that ::findAllSimilar is called correctly.
     *
     * @param object                                                  $entity
     * @param null|\PHPUnit_Framework_MockObject_Matcher_InvokedCount $invokedCount
     *
     * @return \PHPUnit_Framework_MockObject_Builder_InvocationMocker
     */
    protected function expectFindAllSimilar($entity, $invokedCount = null)
    {
        if (null === $invokedCount) {
            $invokedCount = $this->once();
        }

        return $this->controllerMock->expects($invokedCount)
                                    ->method('findAllSimilar')
                                    ->with($entity);
    }

    /**
     * Mock and check if ::createForm has been called correctly.
     *
     * @param AbstractType $expectedClass  Some kind of form.
     * @param object       $expectedObject The entity with all its data.
     *
     * @return \PHPUnit_Framework_MockObject_MockObject
     */
    protected function expectForm($expectedClass, $expectedObject)
    {
        $formMock = $this->getMockBuilder(Form::class)
                         ->disableOriginalConstructor()
                         ->setMethods(
                             [
                                 'createView',
                                 'handleRequest',
                                 'isSubmitted',
                                 'isValid',
                             ]
                         )->getMock();

        $this->controllerMock
            ->expects($this->atLeastOnce())
            ->method('createForm')
            ->with($expectedClass, $expectedObject)
            ->willReturn($formMock);

        return $formMock;
    }

    /**
     * Check if the redirect is correct.
     *
     * @see \Symfony\Bundle\FrameworkBundle\Controller\Controller::redirectToRoute()
     *
     * @param string $expectedRoute      String what the route should be.
     * @param array  $expectedParameters Subset or complete array which data is required at last.
     * @param int    $expectedStatus     Expected HTTP-Status code.
     */
    protected function expectRedirectToRoute($expectedRoute, array $expectedParameters = array(), $expectedStatus = 302)
    {
        $self = $this;

        $this->controllerMock->expects($this->once())->method('redirectToRoute')->willReturnCallback(
            function ($route, array $parameters = array(), $status = 302) use (
                $self,
                $expectedRoute,
                $expectedParameters,
                $expectedStatus
            ) {
                $self->assertEquals($expectedRoute, $route);
                $self->assertArraySubset($expectedParameters, $parameters);
                $self->assertEquals($expectedStatus, $status);
            }
        );
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
                $self->assertEquals($expectedView, $view);
                $self->assertArraySubset($expectedParameters, $parameters);
                $self->assertEquals($expectedResponse, $response);
            }
        );
    }

    protected function mockMethodGetUser()
    {
        $user = new User();

        $this->controllerMock->expects($this->any())
                             ->method('getUser')
                             ->willReturn($user);
    }

    protected function mockRepositoryService($serviceName, $repositoryName)
    {
        $repoMock = $this->getMockBuilder($repositoryName)
                         ->disableOriginalConstructor()
                         ->setMethods(['find'])
                         ->getMock();

        $this->mockService($serviceName, $repoMock);

        return $repoMock;
    }

    /**
     * Replace an service with an mock.
     *
     * @param string $serviceName Slug of the service that shall be overwritten.
     * @param mixed  $return      Value, mostly object, that shall be returned.
     *
     * @return \PHPUnit_Framework_MockObject_Builder_InvocationMocker
     */
    protected function mockService($serviceName, $return = false)
    {
        if (! $this->serviceMap) {
            $self = $this;
            $this->controllerMock->expects($this->any())
                                 ->method('get')
                                 ->willReturnCallback(
                                     function ($serviceName) use ($self) {
                                         if (! isset($self->serviceMap[$serviceName])) {
                                             return null;
                                         }

                                         return $self->serviceMap[$serviceName];
                                     }
                                 );
        }

        if (false !== $return) {
            $this->serviceMap[$serviceName] = $return;
        }
    }

    protected function setUp()
    {
        parent::setUp();

        if (! $this->controllerClass) {
            throw new \LogicException('Please define the controllerClass property for '.get_class($this));
        }

        $this->controllerBuilder = $this->getMockBuilder($this->controllerClass)
                                        ->setMethods($this->getMockedMethods());

        $this->controllerMock = $this->controllerBuilder->getMock();
    }
}