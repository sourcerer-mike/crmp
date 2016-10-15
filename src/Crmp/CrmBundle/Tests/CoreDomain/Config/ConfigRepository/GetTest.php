<?php


namespace Crmp\CrmBundle\Tests\CoreDomain\Config\ConfigRepository;

use Crmp\CrmBundle\CoreDomain\Config\ConfigRepository;


/**
 * Testing the ConfigRepository::get Method.
 *
 * @see     ConfigRepository::get
 *
 * @package Crmp\CrmBundle\Tests\CoreDomain\Config\ConfigRepository
 */
class GetTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var \PHPUnit_Framework_MockObject_MockBuilder
     */
    protected $configRepository;

    protected function setUp()
    {
        $this->configRepository = $this->getMockBuilder(\Crmp\CrmBundle\Repository\ConfigRepository::class)
                                       ->disableOriginalConstructor()
                                       ->setMethods(['findOneBy']);

        parent::setUp();
    }

    /**
     * Invalid configuration keys.
     *
     * @testdox Invalid or not found configuration keys will return null.
     */
    public function testInvalidConfigKeysWillReturnNull()
    {
        $mock = $this->configRepository->getMock();

        $mock->expects($this->any())->method('findOneBy')->willReturn(null);

        /** @var \Crmp\CrmBundle\Repository\ConfigRepository $mock */
        $config = new ConfigRepository($mock);

        $this->assertNull($config->get(''));
    }

    /**
     * Return value.
     */
    public function testItReturnsTheConfigValue()
    {
        $config        = new \stdClass();
        $config->value = uniqid();

        $mock = $this->configRepository->getMock();

        $mock->expects($this->any())->method('findOneBy')->willReturn($config);

        /** @var \Crmp\CrmBundle\Repository\ConfigRepository $mock */
        $repo = new ConfigRepository($mock);

        $this->assertEquals($config->value, $repo->get(''));
    }
}