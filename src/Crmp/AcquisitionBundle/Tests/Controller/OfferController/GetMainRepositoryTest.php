<?php

namespace Crmp\AcquisitionBundle\Tests\Controller\OfferController;


use Crmp\AcquisitionBundle\Controller\OfferController;
use Crmp\AcquisitionBundle\CoreDomain\Offer\OfferRepository;
use Crmp\AcquisitionBundle\Entity\Offer;
use Crmp\CrmBundle\Tests\Controller\AbstractControllerTestCase;
use Crmp\CrmBundle\Tests\UnitTests\Util;
use Symfony\Component\HttpFoundation\Request;

/**
 * Asserting that getting the main repo works correct.
 *
 * @see     OfferController::getMainRepository()
 *
 * @package Crmp\AcquisitionBundle\Tests\Controller\OfferController
 *
 */
class GetMainRepositoryTest extends AbstractControllerTestCase
{
    protected $controllerClass = OfferController::class;

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

        $this->mockService('crmp.offer.repository', $expected);

        $this->assertEquals($expected, Util::call($this->controllerMock, 'getMainRepository'));
    }
}