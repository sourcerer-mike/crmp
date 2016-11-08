<?php

namespace Crmp\AcquisitionBundle\Tests\Controller\InquiryController;


use Crmp\AcquisitionBundle\Controller\InquiryController;
use Crmp\CrmBundle\Tests\Controller\AbstractControllerTestCase;
use Crmp\CrmBundle\Tests\UnitTests\Util;

/**
 * Asserting that getting the main repo works correct.
 *
 * @see     InquiryController::getMainRepository()
 *
 * @package Crmp\AcquisitionBundle\Tests\Controller\InquiryController
 *
 */
class GetMainRepositoryTest extends AbstractControllerTestCase
{
    protected $controllerClass = InquiryController::class;

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

        $this->mockService('crmp.inquiry.repository', $expected);

        $this->assertEquals($expected, Util::call($this->controllerMock, 'getMainRepository'));
    }
}