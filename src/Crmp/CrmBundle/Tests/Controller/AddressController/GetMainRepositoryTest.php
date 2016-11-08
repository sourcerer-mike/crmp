<?php

namespace Crmp\CrmBundle\Tests\Controller\AddressController;


use Crmp\CrmBundle\Controller\AddressController;
use Crmp\CrmBundle\Tests\Controller\AbstractControllerTestCase;
use Crmp\CrmBundle\Tests\UnitTests\Util;

/**
 * Asserting that getting the main repo works correct.
 *
 * @see     AddressController::getMainRepository()
 *
 * @package Crmp\CrmBundle\Tests\Controller\AddressController
 *
 */
class GetMainRepositoryTest extends AbstractControllerTestCase
{
    protected $controllerClass = AddressController::class;

    /**
     * Remove ::getMainRepository() from mocked methods.
     *
     * @return array
     */
    public function getMockedMethods()
    {
        return array_diff(parent::getMockedMethods(), ['getMainRepository']);
    }


    public function testItUsesTheCorrectService()
    {
        $expected            = new \stdClass();
        $expected->something = uniqid();

        $this->mockService('crmp.address.repository', $expected);

        $this->assertEquals($expected, Util::call($this->controllerMock, 'getMainRepository'));
    }
}