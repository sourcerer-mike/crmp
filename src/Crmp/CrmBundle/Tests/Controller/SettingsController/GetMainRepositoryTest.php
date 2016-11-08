<?php

namespace Crmp\CrmBundle\Tests\Controller\SettingsController;


use Crmp\CrmBundle\Controller\SettingsController;
use Crmp\CrmBundle\Tests\Controller\AbstractControllerTestCase;
use Crmp\CrmBundle\Tests\UnitTests\Util;

/**
 * Asserting that getting the main repo works correct.
 *
 * @see     SettingsController::getMainRepository()
 *
 * @package Crmp\CrmBundle\Tests\Controller\SettingsController
 *
 */
class GetMainRepositoryTest extends AbstractControllerTestCase
{
    protected $controllerClass = SettingsController::class;

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

        $this->mockService('crmp.setting.repository', $expected);

        $this->assertEquals($expected, Util::call($this->controllerMock, 'getMainRepository'));
    }
}