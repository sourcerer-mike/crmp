<?php

namespace Crmp\AcquisitionBundle\Tests\Controller\ContractController;


use Crmp\AcquisitionBundle\Controller\ContractController;
use Crmp\CrmBundle\Tests\Controller\AbstractControllerTestCase;
use Crmp\CrmBundle\Tests\UnitTests\Util;

/**
 * Asserting that getting the main repo works correct.
 *
 * @see     ContractController::getMainRepository()
 *
 * @package Crmp\AcquisitionBundle\Tests\Controller\ContractController
 *
 */
class GetMainRepositoryTest extends AbstractControllerTestCase
{
    protected $controllerClass = ContractController::class;

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

        $this->mockService('crmp.contract.repository', $expected);

        $this->assertEquals($expected, Util::call($this->controllerMock, 'getMainRepository'));
    }
}