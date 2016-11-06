<?php

namespace Crmp\CrmBundle\Tests\Panels;

abstract class AbstractPanelTestCase extends \PHPUnit_Framework_TestCase
{

    /**
     * @param $expectedInvoice
     *
     * @param $repositoryClass
     *
     * @return \PHPUnit_Framework_MockObject_MockObject
     */
    protected function expectFindAllSimilar($repositoryClass, $expectedInvoice)
    {
        $repositoryMock = $this->mockRepository($repositoryClass);

        $repositoryMock->expects($this->once())
                       ->method('findAllSimilar')
                       ->with($expectedInvoice);

        return $repositoryMock;
    }

    /**
     * @param string $repositoryClass
     *
     * @return \PHPUnit_Framework_MockObject_MockObject
     */
    protected function expectNotFindAllSimilar($repositoryClass)
    {
        $repositoryMock = $this->mockRepository($repositoryClass);

        $repositoryMock->expects($this->never())
                       ->method('findAllSimilar');

        return $repositoryMock;
    }

    /**
     * @param $className
     *
     * @return \PHPUnit_Framework_MockObject_MockObject
     */
    protected function mockRepository($className)
    {
        $repositoryMock = $this->getMockBuilder($className)
                               ->disableOriginalConstructor()
                               ->setMethods(['findAllSimilar'])
                               ->getMock();

        return $repositoryMock;
    }
}
