<?php


namespace Crmp\CrmBundle\Tests\Controller;


abstract class AbstractControllerTestCase extends \PHPUnit_Framework_TestCase
{
    /**
     * Mock of the customer controller.
     *
     * @var \PHPUnit_Framework_MockObject_MockBuilder
     */
    protected $controllerBuilder;

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
        parent::setUp();

        $this->controllerBuilder = $this->getMockBuilder($this->controllerClass);
    }


}