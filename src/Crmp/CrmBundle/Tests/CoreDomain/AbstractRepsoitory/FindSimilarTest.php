<?php

namespace Crmp\CrmBundle\Tests\CoreDomain\AbstractRepsoitory;

use Crmp\CrmBundle\CoreDomain\AbstractRepository;
use Crmp\CrmBundle\Entity\Setting;
use Doctrine\Common\Collections\Collection;

/**
 * FindSimilarTest
 *
 * @see     AbstractRepository::findSimilar()
 *
 * @package Crmp\CrmBundle\Tests\CoreDomain\AbstractRepsoitory
 */
class FindSimilarTest extends \PHPUnit_Framework_TestCase
{
    public function testItReturnsTheSettingIfFound()
    {
        $setting = new Setting();
        $setting->setName(uniqid());

        $expectedSetting = clone $setting;
        $expectedSetting->setValue(10);
        $expectedSetting->setUser(null);

        $collectionMock = $this->getMockBuilder(Collection::class)
                               ->setMethods(['first'])
                               ->getMockForAbstractClass();

        $collectionMock->expects($this->atLeastOnce())
                       ->method('first')
                       ->willReturn($expectedSetting);

        $abstractRepo = $this->getMockBuilder(AbstractRepository::class)
                             ->disableOriginalConstructor()
                             ->setMethods(['findAllSimilar'])
                             ->getMockForAbstractClass();

        $abstractRepo->expects($this->once())
                     ->method('findAllSimilar')
                     ->with($setting)
                     ->willReturn($collectionMock);

        $this->assertEquals($expectedSetting, $abstractRepo->findSimilar($setting));
    }
}