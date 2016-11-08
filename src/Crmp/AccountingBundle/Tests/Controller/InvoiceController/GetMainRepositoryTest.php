<?php

namespace Crmp\AccountingBundle\Tests\Controller\InvoiceController;


use Crmp\AccountingBundle\Controller\InvoiceController;
use Crmp\CrmBundle\Tests\Controller\AbstractControllerTestCase;
use Crmp\CrmBundle\Tests\UnitTests\Util;

/**
 * Asserting that getting the main repo works correct.
 *
 * @see     InvoiceController::getMainRepository()
 *
 * @package Crmp\AccountingBundle\Tests\Controller\InvoiceController
 *
 */
class GetMainRepositoryTest extends AbstractControllerTestCase
{
    protected $controllerClass = InvoiceController::class;

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

        $this->mockService('crmp.invoice.repository', $expected);

        $this->assertEquals($expected, Util::call($this->controllerMock, 'getMainRepository'));
    }
}